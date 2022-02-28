<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiposAlumno extends Seeder
{
    public function run()
    {
        $data = [
            ['ta_descrip' => 'Profesor'],
            ['ta_descrip' => 'Instructor'],
            ['ta_descrip' => 'Normal'],
        ];

        // Using Query Builder
        $this->db->table('tipo_alumno')->insertBatch($data);
    }
}
