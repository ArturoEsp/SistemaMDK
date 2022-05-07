<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Graficas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre'             => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
            ],
            'modalidad_id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nivel_id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'evento_id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'editable'         => [
                'type'           => 'BOOLEAN',
                'default'        => true,
            ],
            'no_participantes'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'status'             => [
                'type'           => 'ENUM',
                'constraint'     => ['EN_CURSO', 'CANCELADO', 'FINALIZADO'],
                'default'        => 'EN_CURSO',
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('evento_id', 'eventos', 'id_evento');
        $this->forge->addForeignKey('modalidad_id', 'modalidades', 'id_modalidad');
        $this->forge->addForeignKey('nivel_id', 'nivel', 'id_nivel');

        $this->forge->createTable('graficas');
    }

    public function down()
    {
        $this->forge->dropTable('graficas');
    }
}
