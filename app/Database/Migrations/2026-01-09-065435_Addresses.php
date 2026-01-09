<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addresses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'type'           => ['type' => 'ENUM', 'constraint' => ['shipping', 'business', 'other'], 'default' => 'shipping'],
            'is_default'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'label'          => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'recipient_name' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => false],
            'phone_number'   => ['type' => 'VARCHAR', 'constraint' => '15', 'null' => true],
            'address_line'   => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => false],
            'province_id'    => ['type' => 'INT', 'null' => true],
            'city_id'        => ['type' => 'BIGINT', 'null' => true],
            'district_id'    => ['type' => 'BIGINT', 'null' => true],
            'village_id'     => ['type' => 'BIGINT', 'null' => true],
            'province'       => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => false],
            'city'           => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => false],
            'district'       => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => false],
            'village'        => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'zip_code'       => ['type' => 'VARCHAR', 'constraint' => '10', 'null' => false],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}
