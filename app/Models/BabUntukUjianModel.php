<?php

namespace App\Models;

use CodeIgniter\Model;

class BabUntukUjianModel extends Model
{
    protected $table = 'bab_untuk_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_bab', 'id_ujian'];

    public function getUjian($id_bab)
    {
        return $this->where('id_bab', $id_bab)->findColumn('id_ujian');
    }
    public function getBab($id_ujian)
    {
        return $this->where('id_ujian', $id_ujian)->findColumn('id_bab');
    }
}
