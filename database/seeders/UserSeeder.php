<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'fname' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@wsi.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'fname' => 'John',
            'lname' => 'Doe',
            'email' => 'john@wsi.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'fname' => 'Jane',
            'lname' => 'Doe',
            'email' => 'jane@wsi.com',
            'password' => Hash::make('password'),
        ]);
    }
}
