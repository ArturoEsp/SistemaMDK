<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [   
                'usuario' => 'admin',
                'contrasena' => '$2y$10$RlhiUSRALRp.sDjdaomo7OpntM.j8CuCIIXhetZD4dXM4YuoNREzG',
                'nombres' => 'Admin',
                'apellidos' => 'Admin',
                'id_tu' => 1
            ],
        ];

        // Using Query Builder
        $this->db->table('participantes')->insertBatch($data);
    }
}
