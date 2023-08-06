<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LeagueSeasonGroup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_league_season_group' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'null'           => false,
                'autoincrement'  => true
            ],
            'id_league_season' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
        
            'groupname' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
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
        $this->forge->addKey('id_league_season_group', true);
        $this->forge->addForeignKey('id_league_season', 'league_season', 'id_league_season');
        $this->forge->createTable('league_season_group');
    }

    public function down()
    {
        $this->forge->dropTable('league_season_group');
    }
}
