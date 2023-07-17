<?php

namespace App\Models;

use CodeIgniter\Model;

class UserNilaiModel extends Model
{
    protected $table = 'user_nilai';
    protected $useTimestamps = true;
    protected $allowedFields = ['id', 'id_users', 'id_ujian', 'nilai'];

    public function getNilai($id_users, $id_ujian)
    {
        return $this->where(['id_users' => $id_users, 'id_ujian' => $id_ujian])->first();
    }
}
