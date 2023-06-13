<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalUjianModel extends Model
{
    protected $table = 'soal_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_soal', 'id_ujian'];

    public function getSoalUjian($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
    public function getSoalFromSoalUjian($soal_id = false)
    {
        if ($soal_id == false) {
            return $this->findAll();
        }

        return $this->where(['id_soal' => $soal_id])->first();
    }
    public function getSoalIdsByUjianId($id)
    {
        $db = \Config\Database::connect();
        $query = $db->table('soal_ujian')
            ->select(['id_soal'])
            ->where('id_ujian', $id);
        $result = $query->get()->getResult();


        $soalIds = [];

        foreach ($result as $row) {
            $soalIds[] = $row->id_soal;
        }

        return $soalIds;
    }
}
