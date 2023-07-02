<?php

namespace App\Models;

use CodeIgniter\Model;

class UjianModel extends Model
{
    protected $table = 'ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_ujian', 'deskripsi_ujian', 'waktu_buka_ujian', 'waktu_tutup_ujian', 'durasi_ujian', 'nilai_minimum_kelulusan', 'jumlah_soal', 'random', 'tunjukkan_nilai','ruang_ujian','id_mata_kuliah'];

    public function getUjian($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
