<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $admin = User::where('email', 'admin@flyoverbd.com')->first();

        if (! $admin) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@flyoverbd.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@flyoverbd.com');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Admin user already exists!');
            $this->command->info('Email: admin@flyoverbd.com');
        }
    }
}
