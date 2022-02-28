<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Niveles extends Seeder
{
    public function run()
    {
        $data = [
            ['descrip_niv' => 'Preescolar', 'rango' => '4 a 6 años' , 'min_rango' => 4, 'max_rango' => 6],
            ['descrip_niv' => 'Niño', 'rango' => '7 a 13 años', 'min_rango' => 7, 'max_rango' => 13],
            ['descrip_niv' => 'Cadete', 'rango' => '14 a 16 años', 'min_rango' => 14, 'max_rango' => 16],
            ['descrip_niv' => 'Juvenil', 'rango' => '17 a 18 años', 'min_rango' => 17, 'max_rango' => 18],
            ['descrip_niv' => 'Adulto', 'rango' => '19 a 29 años', 'min_rango' => 19, 'max_rango' => 29],
            ['descrip_niv' => 'Master', 'rango' => '30 a 39 años', 'min_rango' => 30, 'max_rango' => 39],
            ['descrip_niv' => 'Submaster', 'rango' => '40 años +', 'min_rango' => 40, 'max_rango' => 1000],
        ];

        // Using Query Builder
        $this->db->table('nivel')->insertBatch($data);
    }
}
