<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\SoalModel;
use App\Models\UjianModel;
use App\Models\KodeUjianModel;
use App\Models\BabUntukUjianModel;
use App\Models\KodeUsersModel;
use App\Models\UserSoalUjianModel;
use Config\Database;

class Mahasiswa extends BaseController
{
    protected $MataKuliahModel;
    protected $BabModel;
    protected $SoalModel;
    protected $UjianModel;
    protected $KodeUjianModel;
    protected $BabUntukUjianModel;
    protected $KodeUsersModel;
    protected $UserSoalUjianModel;
    protected $helpers = ['form', 'auth'];
    public function __construct()
    {
        $this->MataKuliahModel = new MataKuliahModel();
        $this->BabModel = new BabModel();
        $this->UjianModel = new UjianModel();
        $this->SoalModel = new SoalModel();
        $this->KodeUjianModel = new KodeUjianModel();
        $this->BabUntukUjianModel = new BabUntukUjianModel();
        $this->KodeUsersModel = new KodeUsersModel();
        $this->UserSoalUjianModel = new UserSoalUjianModel();
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
    public function randomize($id)
    {
        $assignedBabs = $this->BabUntukUjianModel->where('id_ujian', $id)->findAll();
        $randomizedSoal = [];
        $questionCount = $this->UjianModel->where('id', $id)->findColumn('jumlah_soal')[0];
        $questionPerBab = round($questionCount / count($assignedBabs));
        foreach ($assignedBabs as $index => $assignedBab) {
            $babID = $assignedBab['id_bab'];
            $allSoal = $this->SoalModel->where('id_bab', $babID)->findAll();
            shuffle($allSoal);
            if ($index === count($assignedBabs) - 1) {
                $randomSoal = array_slice($allSoal, 0, $questionCount);
            } else {
                $randomSoal = array_slice($allSoal, 0, $questionPerBab);
                $questionCount -= $questionPerBab;
            }
            $randomizedSoal = array_merge($randomizedSoal, $randomSoal);
        }
        shuffle($randomizedSoal);

        foreach ($randomizedSoal as $soal) {
            $idSoal = $soal['id'];
            $id_user_kode = $this->KodeUsersModel->getKodeUsersId(user_id());
            $existingRecord = $this->UserSoalUjianModel
                ->where('id_soal', $idSoal)
                ->where('id_kode_users', $id_user_kode)
                ->first();

            if ($existingRecord) {
                break;
            }
        }
    }
    public function mulaiUjian($id)
    {
        $selectedQuestionIds = $this->UserSoalUjianModel->where('id_kode_users', 1)->findAll();
        Mahasiswa::randomize($id);
        $soal = [];
        foreach ($selectedQuestionIds as $questionId) {
            $question = $this->SoalModel->find($questionId);
            if ($question) {
                $soal[] = $question[0];
            }
        }
        $data = [
            'title' => 'Bank Soal',
            'ujian' => $this->UjianModel->getUjian($id),
            'soal' => $soal,

        ];

        return view('bankSoal/mahasiswa/mulaiUjian', $data);
    }
}
