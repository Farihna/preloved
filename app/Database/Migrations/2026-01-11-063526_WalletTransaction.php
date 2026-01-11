<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WalletTransaction extends Migration
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
            'wallet_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'transaction_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Reference to transactions table'
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['credit', 'debit'],
                'comment' => 'credit = masuk, debit = keluar'
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'balance_before' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'balance_after' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'reference_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'sale, withdrawal, refund, etc'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('wallet_id');
        $this->forge->addKey('transaction_id');
        $this->forge->addForeignKey('wallet_id', 'wallets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('wallet_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('wallet_transactions');
    }
}
