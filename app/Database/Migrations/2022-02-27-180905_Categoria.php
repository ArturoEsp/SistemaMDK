<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categoria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_categoria'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom_cat'        => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'rango'          => [
                'type'       => 'VARCHAR',
                'constraint' => '40'
            ],
            'min_rango'          => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'max_rango'          => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'genero'          => [
                'type'       => 'VARCHAR',
                'constraint' => '40'
            ],
        ]);
        $this->forge->addKey('id_categoria', true);
        $this->forge->createTable('categoria');
    }

    public function down()
    {
        $this->forge->dropTable('categoria');
    }
}
