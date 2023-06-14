<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\SoalModel;
use App\Models\UjianModel;
use App\Models\SoalUjianModel;
use App\Models\BabUntukUjianModel;
use Config\Database;

class Ujian extends BaseController
{
    protected $MataKuliahModel;
    protected $BabModel;
    protected $SoalModel;
    protected $UjianModel;
    protected $SoalUjianModel;
    protected $BabUntukUjianModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->MataKuliahModel = new MataKuliahModel();
        $this->BabModel = new BabModel();
        $this->SoalModel = new SoalModel();
        $this->UjianModel = new UjianModel();
        $this->SoalUjianModel = new SoalUjianModel();
        $this->BabUntukUjianModel = new BabUntukUjianModel();
    }

    public function tambahUjian($id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'id' => $id,
            'bab' => $this->BabModel->getBab(),
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
            'id' => $id_mata_kuliah
        ];

        return view('bankSoal/dosen/ujian/ubahUjian', $data);
    }

    public function updateUjian($id_mata_kuliah, $id)
    {
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
            'ruang_ujian' => $this->request->getVar('ruang_ujian'),
            'id_mata_kuliah' => $id_mata_kuliah
        ]);
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
            'bab_data' => $babData
        ];

        if (empty($data['ujian'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Soal Ujian ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/dosen/ujian/detailUjian', $data);
    }

    public function ubahSoalUjian($id_mata_kuliah, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'id_mata_kuliah' => $id_mata_kuliah,
            'bab' => $this->BabModel->getBab(),
            'soal' => $this->SoalModel->getSoal(),
            'soal_ujian' => $this->SoalUjianModel->getSoalUjian(),
            'soal_ujian2' => $this->SoalUjianModel,
            'ujian' => $this->UjianModel->getUjian($id),
        ];

        return view('bankSoal/dosen/ujian/ubahSoalUjian', $data);
    }

    public function updateSoalUjian($id_mata_kuliah, $id)
    {
        $checkedSoalIds = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'id_soal_') === 0 && $value) {
                $checkedSoalIds[] = $value;
            }
        }
        $existingSoalIds = $this->SoalUjianModel->getSoalIdsByUjianId($id);
        $uncheckedSoalIds = array_diff($existingSoalIds, $checkedSoalIds);
        foreach ($uncheckedSoalIds as $id_soal) {
            $this->SoalUjianModel->where('id_soal', $id_soal)->delete();
        }
        foreach ($checkedSoalIds as $id_soal) {
            if (!$this->SoalUjianModel->getSoalFromSoalUjian($id_soal)) {
                $this->SoalUjianModel->insert([
                    'id_soal' => $id_soal,
                    'id_ujian' => $id
                ]);
            }
        }
        session()->setFlashdata('pesan_ujian', ' Soal Ujian berhasil diubah');
        return redirect()->to('/banksoal/' . $id_mata_kuliah . '/detail_ujian/' . $id);
    }
}
