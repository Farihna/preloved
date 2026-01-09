<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DistrictPostalCode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'district_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => false,
            ],
            'postal_code_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey(['district_code', 'postal_code_id'], 'district_postal_codes_unique');

        $this->forge->addKey('postal_code_id');
        $this->forge->addKey('district_code');

        $this->forge->addForeignKey('district_code', 'districts', 'district_code', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('postal_code_id', 'postal_codes', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('district_postal_codes');
    }

    public function down()
    {
        $this->forge->dropTable('district_postal_codes');
    }
}
