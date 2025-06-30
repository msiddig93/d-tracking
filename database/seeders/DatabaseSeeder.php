<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'ADMIN',
            'password' => bcrypt('password')
        ]);

        User::updateOrCreate([
            'email' => 'zool.technology010@admin.com'
        ], [
            'name' => 'Zool Technology',
            'password' => bcrypt('password')
        ]);
    }
}
