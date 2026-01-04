<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-user 
                            {--email=admin@flyoverbd.com : Admin email address}
                            {--password=admin123 : Admin password}
                            {--name=Admin User : Admin name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update an admin user for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            $this->info("Admin user updated successfully!");
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            $this->info("Admin user created successfully!");
        }

        $this->newLine();
        $this->info("Login Credentials:");
        $this->line("Email: {$email}");
        $this->line("Password: {$password}");
        $this->newLine();
        $this->info("You can now login at: /login");
        $this->info("Admin Dashboard: /admin/dashboard");

        return Command::SUCCESS;
    }
}
