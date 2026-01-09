<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Districts extends Migration
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
            'city_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addUniqueKey('district_code');
        
        $this->forge->addForeignKey('city_id', 'cities', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('districts');
    }

    public function down()
    {
        $this->forge->dropTable('districts');
    }
}
