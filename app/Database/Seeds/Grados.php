<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Grados extends Seeder
{
    public function run()
    {
        $data = [
            ['nom_grado' => 'Principiante'],
            ['nom_grado' => '10 Kup'],
            ['nom_grado' => '9 Kup'],
            ['nom_grado' => '8 Kup'],
            ['nom_grado' => '7 Kup'],
            ['nom_grado' => '6 Kup'],
            ['nom_grado' => '5 Kup'],
            ['nom_grado' => '4 Kup'],
            ['nom_grado' => '3 Kup'],
            ['nom_grado' => '2 Kup'],
            ['nom_grado' => '1 Kup'],
            ['nom_grado' => 'Ieby Poom'],
            ['nom_grado' => '1 Poom'],
            ['nom_grado' => '2 Poom'],
            ['nom_grado' => '3 Poom'],
            ['nom_grado' => 'Ieby Dan'],
            ['nom_grado' => '1 Dan'],
            ['nom_grado' => '2 Dan'],
            ['nom_grado' => '3 Dan'],
            ['nom_grado' => '4 Dan'],
            ['nom_grado' => '5 Dan'],
            ['nom_grado' => '6 Dan'],
            ['nom_grado' => '7 Dan'],
            ['nom_grado' => '8 Dan'],
            ['nom_grado' => '9 Dan'],
        ];

        // Using Query Builder
        $this->db->table('grados')->insertBatch($data);
    }
}
