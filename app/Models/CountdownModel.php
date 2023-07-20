<?php

namespace App\Models;

use CodeIgniter\Model;

class CountdownModel extends Model
{
    protected $table = 'countdown';
    protected $primaryKey = 'id_kode_users';
    protected $allowedFields = ['id_kode_users', 'remaining_duration'];

    public function getCountdown($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return empty($this->where(['id_kode_users' => $id])->findColumn('remaining_duration')) ? 0 : $this
            ->where(['id_kode_users' => $id])->findColumn('remaining_duration')[0];
    }
    public function saveRemainingDuration($idKodeUsers, $remainingDuration)
    {
        $existingRow = empty($this->where(['id_kode_users' => $idKodeUsers])->first()) ? 0 :
            $this->where(['id_kode_users' => $idKodeUsers]);

        if ($existingRow) {
            // If the id_kode_users exists, update the remaining_duration
            $this->update($idKodeUsers, [
                'remaining_duration' => $remainingDuration
            ]);
        } else {
            // If the id_kode_users doesn't exist, insert a new row
            $this->insert([
                'id_kode_users' => $idKodeUsers,
                'remaining_duration' => $remainingDuration
            ]);
        }
    }
}
