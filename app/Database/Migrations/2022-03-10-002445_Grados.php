<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Grados extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_grado'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nom_grado'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
        ]);

        $this->forge->createTable('grados');
    }

    public function down()
    {
        $this->forge->dropTable('grados');
    }
}
