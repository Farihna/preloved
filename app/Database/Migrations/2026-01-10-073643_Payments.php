<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Payments extends Migration
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
            'transaction_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'payment_method' => [
                'type' => 'ENUM',
                'constraint' => ['midtrans', 'manual_transfer'],
                'default' => 'midtrans',
            ],
            'payment_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'bank_transfer, e-wallet, credit_card, etc'
            ],
            'payment_channel' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'BCA, BNI, Gopay, OVO, etc'
            ],
            'midtrans_order_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'midtrans_transaction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'midtrans_gross_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => true,
            ],
            'midtrans_payment_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'midtrans_transaction_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'midtrans_transaction_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'midtrans_fraud_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'midtrans_status_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'midtrans_signature_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'snap_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'snap_redirect_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'settlement', 'capture', 'deny', 'cancel', 'expire', 'failure'],
                'default' => 'pending',
            ],
            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'expired_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'raw_response' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Store full JSON response from Midtrans'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('transaction_id');
        $this->forge->addKey('midtrans_order_id');
        $this->forge->addKey('payment_status');
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}
