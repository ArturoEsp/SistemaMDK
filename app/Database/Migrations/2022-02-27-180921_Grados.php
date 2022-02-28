<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Grados extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_grado'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom_grado'      => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
        ]);
        $this->forge->addKey('id_grado', true);
        $this->forge->createTable('grados');
    }

    public function down()
    {
        $this->forge->dropTable('grados');
    }
}
