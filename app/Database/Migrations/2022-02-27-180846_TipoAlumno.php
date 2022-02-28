<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TipoAlumno extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ta'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ta_descrip'       => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
        ]);
        $this->forge->addKey('id_ta', true);
        $this->forge->createTable('tipo_alumno');
    }

    public function down()
    {
        $this->forge->dropTable('tipo_alumno');
    }
}
