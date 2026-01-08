<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'transaction_id' => ['type'=>'INT','unsigned'=>true],
            'status' => ['type'=>'VARCHAR','constraint'=>20],
            'notes' => ['type'=>'TEXT','null'=>true],
            'created_by' => ['type'=>'INT','unsigned'=>true,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('transaction_id');

        $this->forge->createTable('transaction_history');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_history');
    }
}
