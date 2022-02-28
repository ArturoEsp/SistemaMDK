<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HistorialGrados extends Migration
{
    public function up()
    {
       /*  $this->forge->addField([
            'id_alumno'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'id_grado'           => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'grado_fecha'        => [
                'type'           => 'DATE'
            ],
        ]);
        $this->forge->addKey('id_grado', true);
        $this->forge->addForeignKey('id_alumno', 'participante', 'id_alumno');
        $this->forge->addForeignKey('id_grado', 'grados', 'id_grado');
        $this->forge->createTable('grados'); */
    }

    public function down()
    {
        //$this->forge->dropTable('grados');
    }
}
