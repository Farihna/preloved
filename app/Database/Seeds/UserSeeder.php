<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $roleOptions = ['user', 'admin'];

        for ($i = 0; $i < 2; $i++) {
            $data = [
                'username' => $faker->userName,
                'email' => $faker->email,
                'img_profile' => 'no_profil.jpg',
                'hp'=> $faker->phoneNumber,
                'password' => password_hash('1234567', PASSWORD_DEFAULT),
                'role' => $roleOptions[$i],
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $this->db->table('user')->insert($data);
        }
    }
}