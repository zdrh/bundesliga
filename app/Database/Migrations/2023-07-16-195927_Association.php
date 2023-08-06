<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Association extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_association' => [
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
        
            'short_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'charset'    => 'utf8',
                'collation'  => 'utf8_unicode_ci',
                'null'       => false
            ],
            'founded' => [
                'type'       => 'INT',
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
        $this->forge->addKey('id_association', true);
       
        $this->forge->createTable('association');
    }

    public function down()
    {
        $this->forge->dropTable('season');
    }
}
