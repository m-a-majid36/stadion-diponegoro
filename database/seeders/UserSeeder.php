<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'          => 'Muhammad Abdul Majid',
                'email'         => 'muhammadabdulmajid36@gmail.com',
                'username'      => 'majid',
                'password'      => bcrypt('password'),
                'role'          => 'M',
            ],
            [
                'name'          => 'Master',
                'email'         => 'master@master.com',
                'username'      => 'master',
                'password'      => bcrypt('password'),
                'role'          => 'M',
            ],
            [
                'name'          => 'Admin',
                'email'         => 'admin@admin.com',
                'username'      => 'admin',
                'password'      => bcrypt('password'),
                'role'          => 'A',
            ],
        ];

        foreach ($user as $data) {
            User::create($data);
        }
    }
}
