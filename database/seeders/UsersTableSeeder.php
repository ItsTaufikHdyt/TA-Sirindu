<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin User',
                'email' => 'super-admin@gmail.com',
                'type' => 0,
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'type' => 1,
                'password' => bcrypt('123456'),
                
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
