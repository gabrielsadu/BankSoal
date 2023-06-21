<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSoalUjianModel extends Model
{
    protected $table = 'user_soal_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_soal', 'id_kode_users'];

    public function getUserSoalUjian($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_kode_users' => $id])->findColumn('id_soal');
    }
}
