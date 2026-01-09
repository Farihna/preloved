<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cities extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'city_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => false,
            ],
            'province_id' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
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
        $this->forge->addUniqueKey('city_code');
        
        // Menambahkan Foreign Key ke tabel provinces
        $this->forge->addForeignKey('province_id', 'provinces', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('cities');
    }

    public function down()
    {
        $this->forge->dropTable('cities');
    }
}
