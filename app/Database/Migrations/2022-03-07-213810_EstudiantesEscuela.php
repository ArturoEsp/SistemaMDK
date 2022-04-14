<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EstudiantesEscuela extends Migration
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
            'id_escuela'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_estudiante'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_estudiante', 'participantes', 'id_alumno',  'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_escuela', 'escuelas', 'id_escuela', 'CASCADE', 'CASCADE');
        $this->forge->createTable('estudiantes_escuela');
    }

    public function down()
    {
        $this->forge->dropTable('estudiantes_escuela');
    }
}
