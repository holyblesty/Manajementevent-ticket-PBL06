<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Masukkan data langsung ke tabel admin sesuai ERD (Tanpa Name, Email, dan Role)
        DB::table('admin')->insert([
            [
                'username' => 'vivian',
                'password' => Hash::make('inirahasiakita'),
            ],
            [
                'username' => 'holy',
                'password' => Hash::make('janganbilang'),
            ],
            [
                'username' => 'lusi',
                'password' => Hash::make('yangtautauaja'),
            ],
        ]);
    }
}