<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GraficasMatchs extends Migration
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
            'no_match'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_area'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'left_player'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'right_player'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'score_left'  => [
                'type'       => 'decimal',
                'constraint' => '10,2',
                'unsigned'       => true,
                'null'           => true,
            ],
            'score_right'     => [
                'type'       => 'decimal',
                'constraint' => '10,2',
                'unsigned'       => true,
                'null'           => true,
            ],
            'grafica_id'     => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],

        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('grafica_id', 'graficas', 'id');
        $this->forge->addForeignKey('left_player', 'evento_participantes', 'id');
        $this->forge->addForeignKey('right_player', 'evento_participantes', 'id');
        $this->forge->addForeignKey('id_area', 'areas', 'id_area');

        $this->forge->createTable('matchs');
    }

    public function down()
    {
        $this->forge->dropTable('matchs');
    }
}
