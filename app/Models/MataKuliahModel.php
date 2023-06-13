<?php

namespace App\Models;

use CodeIgniter\Model;

class MataKuliahModel extends Model
{
    protected $table = 'mata_kuliah';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_mata_kuliah', 'kode_mata_kuliah'];

    public function getMataKuliah($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
