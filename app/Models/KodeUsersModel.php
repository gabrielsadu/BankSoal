<?php

namespace App\Models;

use CodeIgniter\Model;

class KodeUsersModel extends Model
{
    protected $table = 'kode_users';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_ujian', 'id_users'];

    public function getKodeUsers($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_users' => $id])->first();
    }
    public function getKodeUsersId($id)
    {
        return $this->where(['id_users' => $id])->findColumn('id')[0];
    }
}
