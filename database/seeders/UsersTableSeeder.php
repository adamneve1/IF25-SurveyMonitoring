<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus semua pengguna sebelum menyemaikan data baru (opsional)
        DB::table('users')->truncate();

        // Menyemaikan data pengguna
        DB::table('users')->insert([
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            // Manager
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            // SOM
            [
                'name' => 'SOM',
                'email' => 'som@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'som',
            ],
        ]);
    }
}
