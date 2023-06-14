<?php

namespace App\Models;

use CodeIgniter\Model;

class BabUntukUjianModel extends Model
{
    protected $table = 'bab_untuk_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_bab', 'id_ujian'];

    public function getBabUntukUjian($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
    public function getBabIdsByUjianId($id)
    {
        $db = \Config\Database::connect();
        $query = $db->table('bab_ujian')
            ->select(['id_bab'])
            ->where('id_ujian', $id);
        $result = $query->get()->getResult();


        $babIds = [];

        foreach ($result as $row) {
            $babIds[] = $row->id_bab;
        }

        return $babIds;
    }
}
