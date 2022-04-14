<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InsertData extends Seeder
{
    public function run()
    {
        $this->call('TiposUsuario');
        $this->call('TiposAlumno');
        $this->call('Categorias');
        $this->call('Niveles');
        $this->call('Users');
        $this->call('Grados');
        $this->call('Modalidades');
    }
}
