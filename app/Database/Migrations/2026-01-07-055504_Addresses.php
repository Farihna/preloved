<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addresses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'user_id' => ['type'=>'INT','unsigned'=>true],
            'label' => ['type'=>'VARCHAR','constraint'=>50],
            'recipient_name' => ['type'=>'VARCHAR','constraint'=>100],
            'phone' => ['type'=>'VARCHAR','constraint'=>20],
            'address' => ['type'=>'TEXT'],
            'city_id' => ['type'=>'INT'],
            'city_name' => ['type'=>'VARCHAR','constraint'=>100],
            'province' => ['type'=>'VARCHAR','constraint'=>100],
            'postal_code' => ['type'=>'VARCHAR','constraint'=>10,'null'=>true],
            'is_default' => ['type'=>'TINYINT','default'=>0],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['user_id','is_default']);

        $this->forge->createTable('user_addresses');
    }

    public function down()
    {
        $this->forge->dropTable('user_addresses');
    }
}
