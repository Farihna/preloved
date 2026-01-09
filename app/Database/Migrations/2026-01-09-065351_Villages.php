<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Villages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'village_code' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => false],
            'district_id'  => ['type' => 'BIGINT', 'unsigned' => true, 'null' => false],
            'name'         => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => false],
            'created_at'   => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'   => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('village_code');
        $this->forge->addForeignKey('district_id', 'districts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('villages');
    }

    public function down()
    {
        $this->forge->dropTable('villages');
    }
}
