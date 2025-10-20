<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 7; $i++) {
            $data = [
                'username' => $faker->userName,
                'email' => $faker->email,
                'hp'=> $faker->phoneNumber,
                'password' => password_hash('1234567', PASSWORD_DEFAULT),
                'role' => $faker->randomElement(['user', 'admin']),
                'created_at' => date("Y-m-d H:i:s"),
            ];
            //print_r($data);
            $this->db->table('user')->insert($data);
        }
    }
}