<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'id_user' => 1,
                'nama' => 'ASUS TUF A15 FA506NF',
                'harga'  => 10899000,
                'status' => 1,
                'foto' => 'asus_tuf_a15.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id_user' => 1,
                'nama' => 'Asus Vivobook 14 A1404ZA',
                'harga'  => 6899000,
                'status' => 1,
                'foto' => 'asus_vivobook_14.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id_user' => 2,
                'nama' => 'Lenovo IdeaPad Slim 3-14IAU7',
                'harga'  => 6299000,
                'status' => 1,
                'foto' => 'lenovo_idepad_slim_3.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product')->insert($item);
        }
    }
}