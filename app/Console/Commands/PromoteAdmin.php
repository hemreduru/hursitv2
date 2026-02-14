<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:promote-admin {email : User email to promote}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote an existing user account to admin';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->error("User not found: {$email}");
            return self::FAILURE;
        }

        if ($user->is_admin) {
            $this->info("User is already admin: {$email}");
            return self::SUCCESS;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("User promoted to admin: {$email}");
        return self::SUCCESS;
    }
}
