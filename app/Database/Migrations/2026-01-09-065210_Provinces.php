<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Provinces extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'province_code' => ['type' => 'VARCHAR', 'constraint' => '5', 'null' => false],
            'name'          => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => false],
            'created_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('province_code');
        $this->forge->createTable('provinces');
    }

    public function down()
    {
        $this->forge->dropTable('provinces');
    }
}
