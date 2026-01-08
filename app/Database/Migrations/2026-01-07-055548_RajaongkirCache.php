<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RajaongkirCache extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'cache_key' => ['type'=>'VARCHAR','constraint'=>255],
            'cache_type' => [
                'type'=>'ENUM',
                'constraint'=>['province','city','cost']
            ],
            'cache_data' => ['type'=>'TEXT'],
            'expires_at' => ['type'=>'DATETIME'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('cache_key');
        $this->forge->addKey('expires_at');

        $this->forge->createTable('rajaongkir_cache');
    }

    public function down()
    {
        $this->forge->dropTable('rajaongkir_cache');
    }
}
