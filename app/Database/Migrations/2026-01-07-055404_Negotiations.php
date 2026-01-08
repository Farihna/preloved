<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Negotiations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'product_id' => ['type'=>'INT','unsigned'=>true],
            'buyer_id' => ['type'=>'INT','unsigned'=>true],
            'seller_id' => ['type'=>'INT','unsigned'=>true],

            'original_price' => ['type'=>'DECIMAL','constraint'=>'15,2'],
            'offer_price' => ['type'=>'DECIMAL','constraint'=>'15,2'],
            'counter_price' => ['type'=>'DECIMAL','constraint'=>'15,2','null'=>true],

            'buyer_message' => ['type'=>'TEXT','null'=>true],
            'seller_message' => ['type'=>'TEXT','null'=>true],

            'status' => [
                'type'=>'ENUM',
                'constraint'=>['pending','accepted','countered','rejected'],
                'default'=>'pending'
            ],

            'nego_count' => ['type'=>'TINYINT','default'=>1],
            'expires_at' => ['type'=>'DATETIME','null'=>true],

            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['product_id','buyer_id','seller_id']);
        $this->forge->addKey('status');

        $this->forge->createTable('negotiations');
    }

    public function down()
    {
        $this->forge->dropTable('negotiations');
    }
}
