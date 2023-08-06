<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AssociationSeason extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_assoc_season' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'null'           => false,
                'autoincrement'  => true
            ],
            'id_season' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
        
            'id_association' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => false
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
            'logo' => [
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
        $this->forge->addKey('id_assoc_season', true);
        $this->forge->addForeignKey('id_association', 'association', 'id_association');
        $this->forge->addForeignKey('id_league', 'league', 'id_league');
        $this->forge->createTable('association');
    }

    public function down()
    {
        $this->forge->dropTable('association_season');
    }
}
