<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\BabModel;
use App\Models\UjianModel;
use Config\Database;

class Mahasiswa extends BaseController
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
    
    public function masukUjian()
    {
        $data = [
            'title' => 'Bank Soal',
            'mataKuliah' => $this->MataKuliahModel->getMataKuliah()
        ];

        return view('bankSoal/mahasiswa/masukUjian', $data);
    }
}