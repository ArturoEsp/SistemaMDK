<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nivel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_nivel'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'descrip_niv'       => [
                'type'       => 'VARCHAR',
                'constraint' => '70',
            ],
            'rango'          => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'min_rango'      => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'max_rango'      => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->addKey('id_nivel', true);
        $this->forge->createTable('nivel');
    }

    public function down()
    {
        $this->forge->dropTable('nivel');
    }
}
