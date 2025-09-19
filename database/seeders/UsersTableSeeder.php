<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        // Usuario administrador
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin@123'),
            'name' => 'Admin',
            'lastname' => 'IK',
            'is_admin' => true,
        ]);

        // Usuario 1
        User::create([
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make('user1'),
            'name' => 'USUARIO 1',
            'lastname' => 'IKI',
            'is_admin' => false,
        ]);

        // Usuario 2
        User::create([
            'username' => 'user2',
            'email' => 'user2@example.com',
            'password' => Hash::make('user2'),
            'name' => 'USUARIO 2',
            'lastname' => 'IKI',
            'is_admin' => false,
        ]);

        User::create([
            'username' => 'user3',
            'email' => 'user3@example.com',
            'password' => Hash::make('user3'),
            'name' => 'USUARIO 3',
            'lastname' => 'IKI',
            'is_admin' => false, // opcional
        ]);

        User::create([
            'username' => 'user4',
            'email' => 'user4@example.com',
            'password' => Hash::make('user4'),
            'name' => 'USUARIO 4',
            'lastname' => 'IKI',
            'is_admin' => false, // opcional
        ]);


    }


}
