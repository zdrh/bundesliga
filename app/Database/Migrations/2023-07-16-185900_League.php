<?php

namespace App\Database\Migrations\Bundesliga\League;

use CodeIgniter\Database\Migration;

class League extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_league' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'null'           => false,
                'autoincrement'  => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
            'id_association' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'level' => [
                'type'       => 'TINYINT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'created_at' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'updated_at' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'deleted_at' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => true
            ]
           
        ]);
        $this->forge->addKey('id_season', true);
        $this->forge->addForeignKey('id_association', 'association', 'id_association');
        $this->forge->createTable('season');
    }

    public function down()
    {
        $this->forge->dropTable('league');
    }
}
