<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Modalidades extends Seeder
{
    public function run()
    {
        $data = [
            ['modalidad' => 'Formas'],
            ['modalidad' => 'Combates '],
            ['modalidad' => 'Rompimientos'],
        ];

        // Using Query Builder
        $this->db->table('modalidades')->insertBatch($data);
    }
}
