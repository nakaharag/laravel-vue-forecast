<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::query()->delete();

        User::create([
            'name' => 'Gustavo Nakahara',
            'email' => 'gustavo@nakahara.pro',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Lionel Messi',
            'email' => 'lionel@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
