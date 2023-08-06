<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LeagueSeason extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_league_season' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'null'           => false,
                'autoincrement'  => true
            ],
            'id_league' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
        
            'id_assoc_season' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
            'league_name_in_season' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
           
            'groups' => [
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
        $this->forge->addKey('id_league_season', true);
        $this->forge->addForeignKey('id_assoc_season', 'association_season', 'id_assoc_season');
        $this->forge->addForeignKey('id_league', 'league', 'id_league');
        $this->forge->createTable('league_season');
    }

    public function down()
    {
        $this->forge->dropTable('league_season');
    }
}
