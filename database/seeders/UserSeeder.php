<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'webase Solutions',
            'email' => 'hello@webase.com.bd',
            'password' => Hash::make('webase@4950'), // Always hash passwords
            // 'role' => 'admin', // or 'user' depending on your role logic
            'status' => 1, // Assuming 1 is active and 0 is inactive
        ]);
    }
}
