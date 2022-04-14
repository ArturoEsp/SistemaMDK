<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventosModalidades extends Migration
{
    public function up()
    {
        $this->forge->addField([
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
        ]);

        $this->forge->addForeignKey('id_evento', 'eventos', 'id_evento');
        $this->forge->addForeignKey('id_modalidad', 'modalidades', 'id_modalidad');
        $this->forge->createTable('evento_modalidades');
    }

    public function down()
    {
        $this->forge->dropTable('evento_modalidades');
    }
}
