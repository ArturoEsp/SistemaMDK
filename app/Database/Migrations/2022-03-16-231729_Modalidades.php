<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Modalidades extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_modalidad'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'modalidad'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
        ]);

        $this->forge->addKey('id_modalidad', true);
        $this->forge->createTable('modalidades');
    }

    public function down()
    {
        $this->forge->dropTable('modalidades');
    }
}
