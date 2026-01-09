<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostalCode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
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
        $this->forge->addUniqueKey('code', 'postal_codes_code_unique');

        $this->forge->createTable('postal_codes');
    }

    public function down()
    {
        $this->forge->dropTable('postal_codes');
    }
}
