<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@blissbox.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);
        
        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@blissbox.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        $this->call([
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
        ]);
    }
}