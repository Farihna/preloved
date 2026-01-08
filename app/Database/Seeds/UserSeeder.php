<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = [
            'username'     => 'admin123',
            'email'        => 'admin123@gmail.com',
            'img_profile'  => 'no_profil.jpg',
            'hp'           => '081234567890',
            'password'     => password_hash('admin123', PASSWORD_DEFAULT),
            'role'         => 'admin',
            'created_at'   => date("Y-m-d H:i:s"),
        ];

        $user = [
            'username'     => 'user123',
            'email'        => 'user123@gmail.com',
            'img_profile'  => 'no_profil.jpg',
            'hp'           => '081234567891',
            'password'     => password_hash('user123', PASSWORD_DEFAULT),
            'role'         => 'user',
            'created_at'   => date("Y-m-d H:i:s"),
        ];

        $this->db->table('user')->insertBatch([$admin, $user]);
    }
}
