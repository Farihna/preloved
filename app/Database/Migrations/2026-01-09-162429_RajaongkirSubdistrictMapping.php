<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RajaongkirSubdistrictMapping extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'district_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'rajaongkir_subdistrict_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'subdistrict_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('district_id');
        $this->forge->createTable('rajaongkir_subdistrict_mapping');
    }

    public function down()
    {
        $this->forge->dropTable('rajaongkir_subdistrict_mapping');
    }
}
