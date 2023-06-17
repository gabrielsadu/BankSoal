<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\UjianModel;
use App\Models\KodeUjianModel;
use App\Models\BabUntukUjianModel;
use Config\Database;

class Mahasiswa extends BaseController
{
    protected $MataKuliahModel;
    protected $BabModel;
    protected $UjianModel;
    protected $KodeUjianModel;
    protected $BabUntukUjianModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->MataKuliahModel = new MataKuliahModel();
        $this->BabModel = new BabModel();
        $this->UjianModel = new UjianModel();
        $this->KodeUjianModel = new KodeUjianModel();
        $this->BabUntukUjianModel = new BabUntukUjianModel();
    }

    public function masukUjian()
    {
        $data = [
            'title' => 'Bank Soal',
            'mataKuliah' => $this->MataKuliahModel->getMataKuliah()
        ];

        return view('bankSoal/mahasiswa/masukUjian', $data);
    }
    public function mendaftarUjian()
    {
        $kodeUjian = $this->request->getVar('kode_ujian');
        if (!$this->validate([
            'kode_ujian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode masih kosong.'
                ]
            ]

        ])) {
            return redirect()->to('/ujian/masuk_ujian')->withInput();
        }
        if ($kodeUjian === $this->KodeUjianModel->getKodeUjian($kodeUjian)) {
            return redirect()->to('/ujian/detail_ujian/' . $this->KodeUjianModel->getUjian($kodeUjian));
        } else {
            $validation = \Config\Services::validation();
            $validation->setError('kode_ujian', 'Kode Salah');
            return redirect()->to('/ujian/masuk_ujian')->withInput();
        }
    }
    public function detailUjian($id)
    {
        $data = [
            'title' => 'Bank Soal',
            'ujian' => $this->UjianModel->getUjian($id),
        ];

        if (empty($data['ujian'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Soal Ujian ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/mahasiswa/detailUjian', $data);
    }
    public function mulaiUjian($id)
    {
        $data = [
            'title' => 'Bank Soal',
            'ujian' => $this->UjianModel->getUjian($id),
        ];

        if (empty($data['ujian'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Soal Ujian ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/mahasiswa/detailUjian', $data);
    }
}
