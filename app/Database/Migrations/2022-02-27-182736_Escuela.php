<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Escuela extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_escuela'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre'         => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'direccion'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true
            ],
            'id_participante'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id_escuela', true);
        $this->forge->addForeignKey('id_participante', 'participantes', 'id_alumno');
        $this->forge->createTable('escuelas');
    }

    public function down()
    {
        $this->forge->dropTable('escuelas');
    }
}
