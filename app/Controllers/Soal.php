<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\SoalModel;
use Config\Database;

class Soal extends BaseController
{
    protected $MataKuliahModel;
    protected $BabModel;
    protected $SoalModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->MataKuliahModel = new MataKuliahModel();
        $this->BabModel = new BabModel();
        $this->SoalModel = new SoalModel();
    }

    public function daftarSoal($id_mata_kuliah, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'id_mata_kuliah' => $id_mata_kuliah,
            'bab' => $this->BabModel->getBab($id),
            'soal' => $this->SoalModel->getSoal()
        ];

        if (empty($data['bab'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Bab ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/dosen/soal/daftarSoal', $data);
    }

    public function tambahSoal($id_mata_kuliah, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'id_mata_kuliah' => $id_mata_kuliah,
            'id' => $id
        ];

        return view('bankSoal/dosen/soal/tambahSoal', $data);
    }

    public function simpanSoal($id_mata_kuliah, $id)
    {
        $validasi = false;
        $soal = $this->SoalModel->getSoal();
        foreach ($soal as $k) {
            if ($k['id_bab'] == $id) {
                $validasi = true;
            }
        }
        if ($validasi) {
            if (!$this->validate([
                'soal' => [
                    'rules' => 'required|is_unique[soal.soal]',
                    'errors' => [
                        'required' => 'Soal harus diisi.',
                        'is_unique' => 'Soal Bab sudah ada.'
                    ]
                ],

            ])) {
                return redirect()->to('/banksoal/' . $id_mata_kuliah . '/bab/' . $id . '/tambah_soal')->withInput();
            }
        }
        $this->SoalModel->insert([
            'soal' => $this->request->getVar('soal'),
            'jawaban_a' => $this->request->getVar('jawaban_a'),
            'jawaban_b' => $this->request->getVar('jawaban_b'),
            'jawaban_c' => $this->request->getVar('jawaban_c'),
            'jawaban_d' => $this->request->getVar('jawaban_d'),
            'jawaban_benar' => $this->request->getVar('jawaban_benar'),
            'id_bab' => $id
        ]);
        session()->setFlashdata('pesan', 'Soal berhasil ditambahkan');
        return redirect()->to('/banksoal/' . $id_mata_kuliah . '/bab/' . $id);
    }

    public function hapusSoal($id_mata_kuliah, $id_bab, $id)
    {
        $this->SoalModel->delete($id);
        session()->setFlashdata('pesan', 'Soal berhasil dihapus');
        return redirect()->to('/banksoal/' . $id_mata_kuliah . '/bab/' . $id_bab);
    }

    public function ubahSoal($id_mata_kuliah, $id_bab, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'soal' => $this->SoalModel->getSoal($id),
            'id_mata_kuliah' => $id_mata_kuliah,
            'id_bab' => $id_bab
        ];

        return view('bankSoal/dosen/soal/ubahSoal', $data);
    }

    public function updateSoal($id_mata_kuliah, $id_bab, $id)
    {
        $soalLama = $this->SoalModel->getSoal($id);
        if (
            $soalLama['soal'] == $this->request->getVar('soal')
            && $soalLama['jawaban_a'] == $this->request->getVar('jawaban_a')
            && $soalLama['jawaban_b'] == $this->request->getVar('jawaban_b')
            && $soalLama['jawaban_c'] == $this->request->getVar('jawaban_c')
            && $soalLama['jawaban_d'] == $this->request->getVar('jawaban_d')
            && $soalLama['jawaban_benar'] == $this->request->getVar('jawaban_benar')
        ) {
            return redirect()->to('/banksoal/' . $id_mata_kuliah . '/bab/' .  $id_bab . '/ubah_soal/' . $id)->withInput();
        }

        $this->SoalModel->save([
            'id' => $id,
            'soal' => $this->request->getVar('soal'),
            'jawaban_a' => $this->request->getVar('jawaban_a'),
            'jawaban_b' => $this->request->getVar('jawaban_b'),
            'jawaban_c' => $this->request->getVar('jawaban_c'),
            'jawaban_d' => $this->request->getVar('jawaban_d'),
            'jawaban_benar' => $this->request->getVar('jawaban_benar'),
            'id_bab' => $id_bab,
        ]);
        session()->setFlashdata('pesan', 'Soal berhasil diubah');
        return redirect()->to('/banksoal/' . $id_mata_kuliah . '/bab/' .  $id_bab);
    }

    public function detailSoal($id_mata_kuliah, $id_bab, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'soal' => $this->SoalModel->getSoal($id),
            'id_mata_kuliah' => $id_mata_kuliah,
            'id_bab' => $id_bab,
            'bab' => $this->BabModel->getBab($id_bab)
        ];

        if (empty($data['soal'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Bab ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/dosen/soal/detailSoal', $data);
    }

    function uploadGambar()
    {
        if ($this->request->getFile('file')) {
            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getRandomName();
            $dataFile->move("uploads/berkas/", $fileName);
            echo base_url("uploads/berkas/$fileName");
        }
    }

    function deleteGambar()
    {
        $src = $this->request->getVar('src');
        if ($src) {
            $file_name = str_replace(base_url() . "/", "", $src);
            if (unlink($file_name)) {
                echo "Delete file berhasil";
            }
        }
    }
}
