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

        // Check if test user already exists
        $testUser = User::where('email', 'test@example.com')->first();

        if (! $testUser) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            $this->command->info('Test user created successfully!');
        } else {
            $this->command->info('Test user already exists!');
        }

        // Run other seeders
        $this->call([
            AdminUserSeeder::class,
            TourAndVisaSeeder::class,
        ]);
    }
}
