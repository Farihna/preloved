<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VillagePostalCode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'village_code'   => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => false],
            'postal_code_id' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => false],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['village_code', 'postal_code_id'], 'village_postal_codes_unique');
        $this->forge->addKey('postal_code_id');
        $this->forge->addKey('village_code');
        
        // Foreign Keys
        $this->forge->addForeignKey('postal_code_id', 'postal_codes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('village_code', 'villages', 'village_code', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('village_postal_codes');
    }

    public function down()
    {
        $this->forge->dropTable('village_postal_codes');
    }
}
