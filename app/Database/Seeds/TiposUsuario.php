<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiposUsuario extends Seeder
{
    public function run()
    {
        $data = [
            ['tu_descrip' => 'Administrador'],
            ['tu_descrip' => 'Director'],
            ['tu_descrip' => 'Maestro'],
            ['tu_descrip' => 'Recepción'],
            ['tu_descrip' => 'Sistema'],
            ['tu_descrip' => 'Director de área'],
            ['tu_descrip' => 'Encargado de área'],
            ['tu_descrip' => 'Encargado de gráficas'],
            ['tu_descrip' => 'Gráficas'],
            ['tu_descrip' => 'Encargado de premios'],
            ['tu_descrip' => 'Premiación participante'],
        ];

        // Using Query Builder
        $this->db->table('tipo_usuario')->insertBatch($data);
    }
}
