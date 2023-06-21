<?php

namespace App\Models;

use CodeIgniter\Model;

class UserNilaiModel extends Model
{
    protected $table = 'user_nilai';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kode_users', 'nilai'];

    public function getNilai($id_kode_users)
    {
        if ($id_kode_users == false) {
            return $this->findAll();
        }

        return $this->where(['id_kode_users' => $id_kode_users])->findColumn('nilai')[0];
    }
}
