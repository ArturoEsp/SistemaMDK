<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventosParticipantes extends Migration
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
            'id_evento'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_modalidad'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_participante'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'status'             => [
                'type'           => 'ENUM',
                'constraint'     => ['ASIGNADO', 'NO_ASIGNADO'],
                'default'        => 'NO_ASIGNADO',
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_evento', 'eventos', 'id_evento');
        $this->forge->addForeignKey('id_modalidad', 'modalidades', 'id_modalidad');
        $this->forge->addForeignKey('id_participante', 'participantes', 'id_alumno');

        $this->forge->createTable('evento_participantes');
    }

    public function down()
    {
        $this->forge->dropTable('evento_participantes');
    }
}
