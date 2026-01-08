<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'transaction_code' => ['type'=>'VARCHAR','constraint'=>50],

            'product_id' => ['type'=>'INT','unsigned'=>true],
            'buyer_id' => ['type'=>'INT','unsigned'=>true],
            'seller_id' => ['type'=>'INT','unsigned'=>true],
            'negotiation_id' => ['type'=>'INT','unsigned'=>true,'null'=>true],

            'product_price' => ['type'=>'DECIMAL','constraint'=>'15,2'],
            'shipping_cost' => ['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
            'total_amount' => ['type'=>'DECIMAL','constraint'=>'15,2'],

            'shipping_name' => ['type'=>'VARCHAR','constraint'=>100],
            'shipping_phone' => ['type'=>'VARCHAR','constraint'=>20],
            'shipping_address' => ['type'=>'TEXT'],
            'shipping_city_id' => ['type'=>'INT'],
            'shipping_city_name' => ['type'=>'VARCHAR','constraint'=>100],
            'shipping_province' => ['type'=>'VARCHAR','constraint'=>100],
            'shipping_postal_code' => ['type'=>'VARCHAR','constraint'=>10,'null'=>true],

            'courier_code' => ['type'=>'VARCHAR','constraint'=>20],
            'courier_service' => ['type'=>'VARCHAR','constraint'=>50],
            'courier_name' => ['type'=>'VARCHAR','constraint'=>100],
            'estimated_delivery' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'tracking_number' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],

            'payment_proof' => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'payment_date' => ['type'=>'DATETIME','null'=>true],

            'status' => [
                'type'=>'ENUM',
                'constraint'=>['pending','paid','processed','shipped','completed','cancelled','refunded'],
                'default'=>'pending'
            ],

            'notes' => ['type'=>'TEXT','null'=>true],

            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'completed_at' => ['type'=>'DATETIME','null'=>true],
            'cancelled_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('transaction_code');
        $this->forge->addKey(['buyer_id','seller_id','status']);

        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
