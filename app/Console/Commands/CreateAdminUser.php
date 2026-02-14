<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user interactively.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new admin user...');

        $name = $this->ask('Full Name');
        $email = $this->ask('Email Address');
        $password = $this->secret('Password');
        $passwordConfirmation = $this->secret('Confirm Password');

        while ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match. Please try again.');
            $password = $this->secret('Password');
            $passwordConfirmation = $this->secret('Confirm Password');
        }

        $validator = \Illuminate\Support\Facades\Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $this->info("Admin user [{$user->email}] created successfully!");
        return 0;

    }
}
