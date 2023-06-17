<?php

namespace App\Models;

use CodeIgniter\Model;

class KodeUjianModel extends Model
{
    protected $table = 'kode_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_ujian', 'id_ujian'];

    public function getKodeUjian($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        $array = $this->where('kode_ujian', $id)->findColumn('kode_ujian');
        if (empty($array)) {
            return null; 
        }

        return $array[0];
    }
    public function getUjian($kode_ujian)
    {
        return $this->where('kode_ujian', $kode_ujian)->findColumn('id_ujian')[0];
    }
    public function getKodeUjianByUjian($id_ujian)
    {
        return $this->where('id_ujian', $id_ujian)->findColumn('kode_ujian')[0];
    }
}
