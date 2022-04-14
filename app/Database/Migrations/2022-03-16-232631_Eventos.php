<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Eventos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_evento'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'descripcion'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true,
            ],
            'fecha_inicio'    => [
                'type'           => 'DATE'
            ],
            'fecha_fin'    => [
                'type'           => 'DATE',
            ],
            'lugar'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => true,
            ],
            'status'    => [
                'type'           => 'INT',
                'default'        => 1
            ],
        ]);

        $this->forge->addKey('id_evento', true);
        $this->forge->createTable('eventos');
    }

    public function down()
    {
        $this->forge->dropTable('eventos');
    }
}
