<?php

namespace App\Models;

use CodeIgniter\Model;

class BabModel extends Model
{
    protected $table = 'bab';
    protected $useTimestamps = true;
    protected $allowedFields = ['nomor_bab', 'nama_bab', 'id_mata_kuliah'];

    public function getBab($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
