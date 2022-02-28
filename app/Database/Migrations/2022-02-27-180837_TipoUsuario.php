<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TipoUsuario extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tu'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tu_descrip'     => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
        ]);
        $this->forge->addKey('id_tu', true);
        $this->forge->createTable('tipo_usuario');
    }

    public function down()
    {
        $this->forge->dropTable('tipo_usuario');
    }
}
