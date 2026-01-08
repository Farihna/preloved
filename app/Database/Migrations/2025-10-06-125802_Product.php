<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'harga' => [
                'type' => 'DOUBLE',
                'null' => FALSE,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'status' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'weight' => [
                'type'=>'INT',
                'default'=>500,
                'after'=>'status'
            ],
            'city_id' => [
                'type'=>'INT',
                'null'=>true,
                'after'=>'weight'
            ],
            'city_name' => [
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>true,
                'after'=>'city_id'
            ],
            'province' => [
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>true,
                'after'=>'city_name'
            ],
            'is_negotiable' => [
                'type'=>'TINYINT',
                'default'=>1,
                'after'=>'province'
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('product');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('product');
    }
}