<?php

namespace App\Models;

use CodeIgniter\Model;

class KodeUsersModel extends Model
{
    protected $table = 'kode_users';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_ujian', 'id_users'];

    public function getKode($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->findColumn('kode_ujian')[0];
    }
    public function getUsers($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->findColumn('id_users')[0];
    }
    public function getKodeUsersId($id_users, $kode_ujian)
    {
        return empty($this->where(['id_users' => $id_users])
            ->where(['kode_ujian' => $kode_ujian])->findColumn('id')) ? null : $this
            ->where(['id_users' => $id_users])->where(['kode_ujian' => $kode_ujian])->findColumn('id')[0];
    }
}
