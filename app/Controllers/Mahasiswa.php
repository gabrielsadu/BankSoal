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
use App\Models\UserNilaiModel;
use App\Models\CountdownModel;
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
    protected $UserNilaiModel;
    protected $CountdownModel;
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
        $this->UserNilaiModel = new UserNilaiModel();
        $this->CountdownModel = new CountdownModel();
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
        if ($this->KodeUjianModel->getKodeUjian($kodeUjian)) {
            if (!$this->KodeUsersModel->getKodeUsersId(user_id(), $kodeUjian)) {
                $this->KodeUsersModel->insert([
                    'id_users' => user_id(),
                    'kode_ujian' => $kodeUjian,
                ]);
            }
            $kodeUsers = $this->KodeUsersModel->getKodeUsersId(user_id(), $kodeUjian);
            return redirect()->to('/ujian/detail_ujian/' . $kodeUsers);
        } else {
            $validation = \Config\Services::validation();
            $validation->setError('kode_ujian', 'Kode Salah');
            return redirect()->to('/ujian/masuk_ujian')->withInput();
        }
    }
    public function detailUjian($id)
    {
        $kodeUjian = $this->KodeUsersModel->getKode($id);
        $idUjian = $this->KodeUjianModel->getUjian($kodeUjian);
        $data = [
            'title' => 'Bank Soal',
            'ujian' => $this->UjianModel->getUjian($idUjian),
            'id_kode_users' => $id
        ];

        if (empty($data['ujian'])) {
            throw new \codeIgniter\Exceptions\PageNotFoundException('Id Sesi ' . $id . ' tidak ditemukan.');
        }

        return view('bankSoal/mahasiswa/detailUjian', $data);
    }
    public function randomize($id)
    {
        $kodeUjian = $this->KodeUsersModel->getKode($id);
        $id_ujian = $this->KodeUjianModel->getUjian($kodeUjian);
        $assignedBabs = $this->BabUntukUjianModel->where('id_ujian', $id_ujian)->findColumn('id_bab');
        $randomizedSoal = [];
        $questionCount = $this->UjianModel->where('id', $id_ujian)->findColumn('jumlah_soal')[0];
        $questionPerBab = round($questionCount / count($assignedBabs));
        foreach ($assignedBabs as $index => $assignedBab) {
            $allSoal = $this->SoalModel->where('id_bab', $assignedBab)->findAll();
            if ($index === count($assignedBabs) - 1) {
                $randomSoal = array_slice($allSoal, 0, $questionCount);
            } else {
                $randomSoal = array_slice($allSoal, 0, $questionPerBab);
                $questionCount -= $questionPerBab;
            }
            $randomizedSoal = array_merge($randomizedSoal, $randomSoal);
        }
        foreach ($randomizedSoal as $soal) {
            $idSoal = $soal['id'];
            $existingRecord = $this->UserSoalUjianModel
                ->where('id_soal', $idSoal)
                ->where('id_kode_users', $id)
                ->first();

            if (!empty($existingRecord)) {
                break;
            }
            $this->UserSoalUjianModel->insert([
                'id_soal' => $idSoal,
                'id_kode_users' => $id,
            ]);
        }
    }
    public function simpanJawabanDipilih()
    {
        $this->UserSoalUjianModel->where('id_kode_users', $this->request->getPost('id_kode_users'))
            ->where('id_soal', $this->request->getPost('id_soal'))
            ->set(['jawaban_dipilih' => $this->request->getPost('jawaban_dipilih')])
            ->update();

        // Return a response if needed
        return $this->response->setJSON(['success' => true]);
    }
    public function mulaiUjian($id)
    {
        $kodeUjian = $this->KodeUsersModel->getKode($id);
        $idUjian = $this->KodeUjianModel->getUjian($kodeUjian);
        Mahasiswa::randomize($id);
        $selectedQuestionIds = $this->UserSoalUjianModel->getSoalId($id);
        $selectedAnswers = $this->UserSoalUjianModel->getSoalIdAndJawabanDipilih($id);
        $currentPage = $this->request->getVar('page_soal') ? $this->request->getVar('page_soal') : 1;
        $data = [
            'title' => 'Bank Soal',
            'ujian' => $this->UjianModel->getUjian($idUjian),
            'soal' =>  $this->SoalModel->whereIn('id', $selectedQuestionIds)->paginate(1, 'soal'),
            'pager' => $this->SoalModel->whereIn('id', $selectedQuestionIds)->pager,
            'currentPage' => $currentPage,
            'jawaban' => $selectedAnswers,
            'id' => $id
        ];

        return view('bankSoal/mahasiswa/mulaiUjian', $data);
    }
    public function hasilUjian($id)
    {
        $kodeUjian = $this->KodeUsersModel->getKode($id);
        $idUjian = $this->KodeUjianModel->getUjian($kodeUjian);
        $ujian = $this->UjianModel->getUjian($idUjian);
        $soals_id = $this->UserSoalUjianModel->getUserSoalUjian($id);
        $soals = $this->SoalModel->whereIn('id', $soals_id)->findAll();
        $nilai = [];
        /** @var string $cookie_data */
        $cookie_data = $this->request->getCookie('selected_answers');
        $selectedAnswers = (array) json_decode($cookie_data);

        foreach ($soals as $soal) {
            $jawaban = isset($selectedAnswers[$soal['id']]) ? $selectedAnswers[$soal['id']] : '';
            $isCorrect = ($jawaban === $soal['jawaban_benar']);
            array_push($nilai, $isCorrect);
        }

        $nilai = (array_sum($nilai) / count($nilai)) * 100;
        $existingRecord = $this->UserNilaiModel->findColumn('id_kode_users', $id);

        if (!$existingRecord) {
            $this->UserNilaiModel->insert([
                'nilai' => $nilai,
                'id_kode_users' => $id,
            ]);
        }
        $data = [
            'title' => 'Bank Soal',
            'nilai' => $nilai,
            'ujian' => $ujian,
            'soalUjian' =>  $soals,
            'selected_answers' => $selectedAnswers,
            'id' => $id
        ];
        return view('bankSoal/mahasiswa/hasilUjian', $data);
    }
}
