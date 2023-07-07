<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiKeyModel extends Model
{
    protected $table = 'apikeys';

    


    public function getValidApiKeys()
    {
        $db = \Config\Database::connect();
        echo 'Connected to database: ' . $db->getDatabase();
        $query = $this->db->table($this->table)
            ->select('key')
            ->where('is_valid', true)
            ->get();

        echo 'Query SQL: ' . $query->getCompiledSelect();
        echo 'Result count: ' . $query->getNumRows();

        $keys = [];
        foreach ($query->getResultArray() as $row) {
            $keys[] = $row['key'];
        }

        return $keys;
    }

}
