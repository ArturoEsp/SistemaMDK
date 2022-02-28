<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Participante extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alumno'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario'      => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true
            ],
            'contrasena'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true
            ],
            'nombres'      => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'apellidos'      => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'sexo'           => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0,
            ],
            'edad'           => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true
            ],
            'altura'           => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true
            ],
            'peso'           => [
                'type'       => 'decimal',
                'constraint' => '10,2',
                'null'       => true
            ],
            'fotografia'     => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true
            ],
            'id_tu'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_ta'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'unsigned' => true
            ],
            'id_categoria'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'unsigned' => true
            ],
            'id_nivel'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'unsigned' => true
            ]      
        ]);

        $this->forge->addKey('id_alumno', true);

        $this->forge->addForeignKey('id_tu', 'tipo_usuario', 'id_tu');
        $this->forge->addForeignKey('id_ta', 'tipo_alumno', 'id_ta');
        $this->forge->addForeignKey('id_categoria', 'categoria', 'id_categoria');
        $this->forge->addForeignKey('id_nivel', 'nivel', 'id_nivel');

        $this->forge->createTable('participantes');
    }

    public function down()
    {
        $this->forge->dropTable('participantes');
    }
}
