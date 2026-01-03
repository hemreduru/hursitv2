<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateApiUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:create-user {email=n8n@bot.com} {name=n8n Bot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an API user and generate a Sanctum token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::random(32)),
                'email_verified_at' => now(),
            ]
        );

        $this->info("User found/created: {$user->name} ({$user->email})");

        if ($this->confirm('Do you want to generate a new token?', true)) {
            $token = $user->createToken('api-token')->plainTextToken;

            $this->newLine();
            $this->info('API Token Generated Successfully:');
            $this->line($token);
            $this->newLine();
            $this->warn('Copy this token now. It will not be shown again.');
        }
    }
}
