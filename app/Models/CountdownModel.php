<?php

namespace App\Models;

use CodeIgniter\Model;

class CountdownModel extends Model
{
    protected $table = 'countdown';
    protected $allowedFields = ['id_kode_users', 'start_time', 'remaining_duration'];

    public function getCoutdown($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_kode_users' => $id])->select('start_time', 'remaining_duration')->findAll();
    }
}
