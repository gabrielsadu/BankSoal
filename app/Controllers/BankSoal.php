<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\UjianModel;
use Config\Database;

class BankSoal extends BaseController
{
    protected $MataKuliahModel;
    protected $BabModel;
    protected $UjianModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->MataKuliahModel = new MataKuliahModel();
        $this->BabModel = new BabModel();
        $this->UjianModel = new UjianModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Bank Soal',
            'mataKuliah' => $this->MataKuliahModel->getMataKuliah()
        ];

        return view('bankSoal/dosen/index', $data);
    }

    public function daftarBab($id)
    {
        $data = [
            'title' => 'Bank Soal',
            'mataKuliah' => $this->MataKuliahModel->getMataKuliah($id),
            'bab' => $this->BabModel->getBab(),
            'ujian' => $this->UjianModel->getUjian()
        ];

        if (empty($data['mataKuliah'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Mata Kuliah ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/dosen/bab/daftarBab', $data);
    }

    public function tambahBab($id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'id' => $id
        ];

        return view('bankSoal/dosen/bab/tambahBab', $data);
    }

    public function simpanBab($id)
    {
        $db = \Config\Database::connect();
        $query = $db->table('bab')
            ->select(['nama_bab', 'nomor_bab'])
            ->where('id_mata_kuliah', $id)
            ->where('nama_bab', $this->request->getVar('nama_bab'))
            ->orWhere('nomor_bab', $this->request->getVar('nomor_bab'))
            ->where('id_mata_kuliah', $id);
        $result = $query->get()->getResultArray();
        if ($result) {
            $same_nama = array_filter($result, function ($row) {
                return $row['nama_bab'] === $this->request->getVar('nama_bab');
            });
            $same_nomor = array_filter($result, function ($row) {
                return $row['nomor_bab'] === $this->request->getVar('nomor_bab');
            });
            $rules_nama_bab = $same_nama ? 'required|is_unique[bab.nama_bab]' : 'required';
            $rules_nomor_bab = $same_nomor ? 'required|is_unique[bab.nomor_bab]' : 'required';
        } else {
            $rules_nama_bab = 'required';
            $rules_nomor_bab = 'required';
        }
        if (!$this->validate([
            'nomor_bab' => [
                'rules' => $rules_nomor_bab,
                'errors' => [
                    'required' => 'Nomor Bab harus diisi.',
                    'is_unique' => 'Nomor Bab sudah ada.'
                ]
            ],
            'nama_bab' => [
                'rules' => $rules_nama_bab,
                'errors' => [
                    'required' => 'Nama Bab harus diisi.',
                    'is_unique' => 'Nama Bab sudah ada.'
                ]
            ],

        ])) {
            return redirect()->to('/banksoal/' . $id . '/tambah_bab')->withInput();
        }
        $this->BabModel->insert([
            'nomor_bab' => $this->request->getVar('nomor_bab'),
            'nama_bab' => $this->request->getVar('nama_bab'),
            'id_mata_kuliah' => $id
        ]);
        session()->setFlashdata('pesan_bab', 'Bab berhasil ditambahkan');
        return redirect()->to('/banksoal/' . $id);
    }

    public function hapusBab($id_mata_kuliah, $id)
    {
        $this->BabModel->delete($id);
        session()->setFlashdata('pesan', 'Bab berhasil dihapus');
        return redirect()->to('/banksoal/' . $id_mata_kuliah);
    }

    public function ubahBab($id_mata_kuliah, $id)
    {
        $data = [
            'title' => 'Bank Soal',
            'validation' => \Config\Services::validation(),
            'bab' => $this->BabModel->getBab($id),
            'id' => $id_mata_kuliah
        ];
        session()->setFlashdata('pesan_bab', 'Bab berhasil ubah');
        return view('bankSoal/dosen/bab/ubahBab', $data);
    }

    public function updateBab($id_mata_kuliah, $id)
    {
        $babLama = $this->BabModel->getBab($id);
        if ($babLama['nomor_bab'] == $this->request->getVar('nomor_bab') && $babLama['nama_bab'] == $this->request->getVar('nama_bab')) {
            return redirect()->to('/banksoal/' . $id_mata_kuliah . '/ubah_bab/' . $id)->withInput();
        }

        $this->BabModel->save([
            'id' => $id,
            'nomor_bab' => $this->request->getVar('nomor_bab'),
            'nama_bab' => $this->request->getVar('nama_bab'),
            'id_mata_kuliah' => $id_mata_kuliah,
        ]);
        session()->setFlashdata('pesan', 'Bab berhasil diubah');
        return redirect()->to('/banksoal/' . $id_mata_kuliah);
    }
}
