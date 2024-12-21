<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    // jalankan command 'php artisan db:seed --class=AdminSeeder'
    public function run(): void
    {
        //Seeder admin email 'admin@lks.com' password: '1234'
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@lks.com',
            'password' => Hash::make('1234'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'is_admin' => 1,
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Operasional',
            'email' => 'user@lks.com',
            'password' => Hash::make('1234'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'is_admin' => 0,
        ]);
    }
}