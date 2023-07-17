<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\SoalModel;
use App\Models\UjianModel;
use App\Models\KodeUjianModel;
use App\Models\BabUntukUjianModel;
use App\Models\UserNilaiModel;
use App\Models\UsersModel;


use Config\Database;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Ujian extends BaseController
{
    protected $MataKuliahModel;
    protected $BabModel;
    protected $SoalModel;
    protected $UjianModel;
    protected $KodeUjianModel;
    protected $BabUntukUjianModel;
    protected $UserNilaiModel;
    protected $UsersModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->MataKuliahModel = new MataKuliahModel();
        $this->BabModel = new BabModel();
        $this->SoalModel = new SoalModel();
        $this->UjianModel = new UjianModel();
        $this->KodeUjianModel = new KodeUjianModel();
        $this->BabUntukUjianModel = new BabUntukUjianModel();
        $this->UsersModel = new UsersModel();
        $this->UserNilaiModel = new UserNilaiModel();
    }

    public function tambahUjian($id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'id' => $id,
            'bab' => $this->BabModel->getBab()
        ];

        return view('bankSoal/dosen/ujian/tambahUjian', $data);
    }

    public function simpanUjian($id)
    {
        $db = \Config\Database::connect();
        $query = $db->table('ujian')
            ->select(['nama_ujian'])
            ->where('id_mata_kuliah', $id)
            ->where('nama_ujian', $this->request->getVar('nama_ujian'))
            ->where('id_mata_kuliah', $id);
        $result = $query->get()->getResultArray();
        if ($result) {
            $same_nama = array_filter($result, function ($row) {
                return $row['nama_ujian'] === $this->request->getVar('nama_ujian');
            });
            $rules_nama_ujian = $same_nama ? 'required|is_unique[ujian.nama_ujian]' : 'required';
        } else {
            $rules_nama_ujian = 'required';
        }
        if (!$this->validate([
            'nama_ujian' => [
                'rules' => $rules_nama_ujian,
                'errors' => [
                    'required' => 'Nama Ujian harus diisi.',
                    'is_unique' => 'Nama Ujian sudah ada.'
                ]
            ],

        ])) {
            return redirect()->to('/banksoal/' . $id . '/tambah_ujian')->withInput();
        }
        $waktu_buka_ujian = $this->request->getVar('waktu_buka_ujian');
        $waktu_tutup_ujian = $this->request->getVar('waktu_tutup_ujian');
        $random = isset($_POST['random']) ? 1 : 0;
        $tunjukkan_nilai = isset($_POST['tunjukkan_nilai']) ? 1 : 0;
        $pilih_soal = $this->request->getpost('bab');
        $this->UjianModel->insert([
            'nama_ujian' => $this->request->getVar('nama_ujian'),
            'deskripsi_ujian' => $this->request->getVar('deskripsi_ujian'),
            'waktu_buka_ujian' => date('Y-m-d H:i:s', strtotime($waktu_buka_ujian)),
            'waktu_tutup_ujian' => date('Y-m-d H:i:s', strtotime($waktu_tutup_ujian)),
            'durasi_ujian' => $this->request->getVar('durasi_ujian'),
            'nilai_minimum_kelulusan' => $this->request->getVar('nilai_minimum_kelulusan'),
            'jumlah_soal' => $this->request->getVar('jumlah_soal'),
            'random' => $random,
            'tunjukkan_nilai' => $tunjukkan_nilai,
            'ruang_ujian' => $this->request->getVar('ruang_ujian'),
            'id_mata_kuliah' => $id
        ]);
        $insert_id = $this->UjianModel->getInsertID();
        foreach ($pilih_soal as $value) {
            $this->BabUntukUjianModel->insert([
                'id_bab' => $value,
                'id_ujian' => $insert_id
            ]);
        }

        session()->setFlashdata('pesan_ujian', 'Ujian berhasil ditambahkan');
        return redirect()->to('/banksoal/' . $id);
    }

    public function hapusUjian($id_mata_kuliah, $id)
    {
        $this->UjianModel->delete($id);
        session()->setFlashdata('pesan', 'Ujian berhasil dihapus');
        return redirect()->to('/banksoal/' . $id_mata_kuliah);
    }

    public function ubahUjian($id_mata_kuliah, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'ujian' => $this->UjianModel->getUjian($id),
            'id' => $id_mata_kuliah,
            'bab' => $this->BabModel->getBab(),
            'bab_untuk_ujian' => $this->BabUntukUjianModel->getBab($id)
        ];

        return view('bankSoal/dosen/ujian/ubahUjian', $data);
    }

    public function updateUjian($id_mata_kuliah, $id)
    {
        $ruang_ujian = $this->request->getVar('ruang_ujian');
        if ((null == $ruang_ujian)) {
            $ruang_ujian = null;
        }
        $random = (null !== ($this->request->getVar('random')) ? 1 : 0);
        $tunjukkan_nilai = (null !== ($this->request->getVar('tunjukkan_nilai')) ? 1 : 0);
        $waktu_buka_ujian = $this->request->getVar('waktu_buka_ujian');
        $waktu_tutup_ujian = $this->request->getVar('waktu_tutup_ujian');
        $ujianLama = $this->UjianModel->getUjian($id);
        if (
            $ujianLama['nama_ujian'] == $this->request->getVar('nama_ujian')
            && $ujianLama['deskripsi_ujian'] == $this->request->getVar('deskripsi_ujian')
            && $ujianLama['waktu_buka_ujian'] == date('Y-m-d H:i:s', strtotime($waktu_buka_ujian))
            && $ujianLama['waktu_tutup_ujian'] == date('Y-m-d H:i:s', strtotime($waktu_tutup_ujian))
            && $ujianLama['durasi_ujian'] == $this->request->getVar('durasi_ujian')
            && $ujianLama['nilai_minimum_kelulusan'] == $this->request->getVar('nilai_minimum_kelulusan')
            && $ujianLama['ruang_ujian'] == $this->request->getVar('ruang_ujian')
            && $ujianLama['jumlah_soal'] == $this->request->getVar('jumlah_soal')
            && $ujianLama['random'] == $this->request->getVar('random')
            && $ujianLama['tunjukkan_nilai'] == $this->request->getVar('tunjukkan_nilai')
        ) {
            return redirect()->to('/banksoal/' . $id_mata_kuliah . '/ubah_ujian/' . $id)->withInput();
        }
        $this->UjianModel->save([
            'id' => $id,
            'nama_ujian' => $this->request->getVar('nama_ujian'),
            'deskripsi_ujian' => $this->request->getVar('deskripsi_ujian'),
            'waktu_buka_ujian' => date('Y-m-d H:i:s', strtotime($waktu_buka_ujian)),
            'waktu_tutup_ujian' => date('Y-m-d H:i:s', strtotime($waktu_tutup_ujian)),
            'durasi_ujian' => $this->request->getVar('durasi_ujian'),
            'nilai_minimum_kelulusan' => $this->request->getVar('nilai_minimum_kelulusan'),
            'ruang_ujian' => $ruang_ujian,
            'jumlah_soal' => $this->request->getVar('jumlah_soal'),
            'random' => $random,
            'tunjukkan_nilai' => $tunjukkan_nilai,
            'id_mata_kuliah' => $id_mata_kuliah
        ]);

        $pilih_soal = $this->request->getpost('bab');

        $bab_untuk_ujian = $this->BabUntukUjianModel->getBab($id);

        foreach ($pilih_soal as $bab_id) {
            $found = false;
            foreach ($bab_untuk_ujian as $row) {
                if ($row == $bab_id) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->BabUntukUjianModel->insert(['id_ujian' => $id, 'id_bab' => $bab_id]);
            }
        }
        foreach ($bab_untuk_ujian as $row) {
            $found = false;
            foreach ($pilih_soal as $bab_id) {
                if ($row == $bab_id) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->BabUntukUjianModel->where('id_ujian', $id)->where('id_bab', $row)->delete();
            }
        }
        session()->setFlashdata('pesan', 'Ujian berhasil diubah');
        return redirect()->to('/banksoal/' . $id_mata_kuliah);
    }

    public function detailUjian($id_mata_kuliah, $id)
    {
        $filteredData =  $this->BabUntukUjianModel->where('id_ujian', $id)->findAll();
        $babData = array();
        foreach ($filteredData as $row) {
            $idBab = $row['id_bab'];
            $bab = $this->BabModel->find($idBab);
            if ($bab) {
                $babData[] = $bab;
            }
        }
        $data = [
            'title' => 'Bank Soal',
            'id_mata_kuliah' => $id_mata_kuliah,
            'ujian' => $this->UjianModel->getUjian($id),
            'soal_model' => $this->SoalModel->getSoal(),
            'bab_data' => $babData,
            'kode_ujian' => $this->KodeUjianModel->getKodeUjianByUjian($id),
        ];

        if (empty($data['ujian'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Soal Ujian ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/dosen/ujian/detailUjian', $data);
    }
    public function saveCode()
    {
        $kode_ujian = $this->request->getPost('kode_ujian');
        $id_ujian = $this->request->getPost('id_ujian');

        // Insert the code into the KodeUjianModel
        $kodeUjianModel = new KodeUjianModel();
        $data = [
            'kode_ujian' => $kode_ujian,
            'id_ujian' => $id_ujian
        ];
        $kodeUjianModel->insert($data);

        // Send a response indicating success
        return $this->response->setJSON(['success' => true]);
    }

    public function exportToExcel($id)
    {
        $ujian = $this->UjianModel->getUjian($id);
        $namaUjian = $ujian['nama_ujian'];
        $stringLowercase = strtolower($namaUjian);
        $stringWithUnderscores = str_replace(' ', '_', $stringLowercase);
        
        $nilai = $this->UserNilaiModel->where('id_ujian', $id)->findAll();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set the active sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers to the first row
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nilai');
        $sheet->setCellValue('D1', 'Tanggal');

        // Iterate over the results and add them to the spreadsheet
        $row = 2;
        foreach ($nilai as $result) {
            $user = $this->UsersModel->GetUser($result['id_users']);
            $nama_user = $user['fullname'];
            $username_user = $user['username'];
            $sheet->setCellValue('A' . $row, $nama_user);
            $sheet->setCellValue('B' . $row, $username_user);
            $sheet->setCellValue('C' . $row, $result['nilai']);
            $sheet->setCellValue('D' . $row, $result['updated_at']);
            $row++;
        }

        // Create a new Excel file writer
        $writer = new Xlsx($spreadsheet);

        // Set the appropriate headers for the response
        $fileName = 'hasil_ujian_'. $stringWithUnderscores .'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Save the spreadsheet file to the response output
        $writer->save('php://output');
        die;
    }
}
