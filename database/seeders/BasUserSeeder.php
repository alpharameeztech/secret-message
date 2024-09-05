<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BasUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'bas@gmail.com')->exists()) {
            \Log::info('Creating BAS user because it does not exist.');
            User::create([
                'name' => 'BAS User',
                'email' => 'bas@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
