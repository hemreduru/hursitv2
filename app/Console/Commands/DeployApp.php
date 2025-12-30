<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeployApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy {--force : Force the operation to run when in production} {--seed : Seed database with CV data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application for production (migrate, seed, build, cache, optimize).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting production deployment process...');

        // 0. Configuration Wizard
        if ($this->option('force') || $this->confirm('Do you want to run the Environment Setup Wizard? (Recommended for first deploy)', false)) {
            $this->setupWizard();
        }

        // 1. Dependency Optimization
        $this->info('1/7 Optimizing dependencies...');
        $this->runShell('composer install --no-dev --optimize-autoloader');

        // 2. Database Migration
        $this->info('2/7 Migrating database...');
        $this->call('migrate', ['--force' => true]);

        // 3. Database Seeding (Optional)
        if ($this->option('seed')) {
            $this->info('3/7 Seeding database with CV data...');
            $this->call('db:seed', [
                '--class' => 'DatabaseSeeder',
                '--force' => true
            ]);
        } else {
            $this->info('3/7 Skipping database seeding (use --seed to enable)...');
        }

        // 4. Storage Linking
        $this->info('4/7 Linking storage...');
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        } else {
            $this->line('   Storage already linked.');
        }

        // 5. Build Assets
        $this->info('5/7 Building frontend assets...');
        $this->runShell('npm run build');

        // 6. Caching & Optimization
        $this->info('6/7 Caching configuration and routes...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        // 7. Queue Restart
        $this->info('7/7 Restarting queues...');
        $this->call('queue:restart');

        $this->info('----------------------------------------');
        $this->info('Deployment completed successfully! 🚀');
        $this->info('Your application is now live and optimized.');
        $this->info('----------------------------------------');

        return 0;
    }

    private function runShell($command)
    {
        $this->line("   > $command");
        $output = shell_exec($command);
        $this->line($output);
    }

    private function setupWizard()
    {
        $this->info('--- Environment Setup Wizard ---');

        $currentAppName = config('app.name');
        $currentAppUrl = config('app.url');
        $currentLocale = config('app.locale');
        $currentRecaptchaSite = config('services.recaptcha.site_key');
        $currentRecaptchaSecret = config('services.recaptcha.secret_key');

        $appName = $this->ask('Application Name', $currentAppName);
        $appUrl = $this->ask('Application URL', $currentAppUrl);
        $appLocale = $this->choice('Default Language', ['tr', 'en'], $currentLocale);

        $this->info('--- Google ReCaptcha v3 Settings ---');
        $this->info('These are required for login security.');

        $recaptchaSiteKey = $this->ask('ReCaptcha Site Key', $currentRecaptchaSite);
        $recaptchaSecretKey = $this->ask('ReCaptcha Secret Key', $currentRecaptchaSecret);

        $this->updateEnvironmentFile([
            'APP_NAME' => '"' . $appName . '"',
            'APP_URL' => $appUrl,
            'APP_LOCALE' => $appLocale,
            'RECAPTCHA_SITE_KEY' => $recaptchaSiteKey,
            'RECAPTCHA_SECRET_KEY' => $recaptchaSecretKey,
        ]);

        $this->info('Configuration updated successfully.');
        $this->call('config:clear'); // Clear cache to apply changes immediately
    }

    private function updateEnvironmentFile(array $data)
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            $this->error('.env file not found!');
            return;
        }

        $content = file_get_contents($path);

        foreach ($data as $key => $value) {
            // Check if key exists
            if (preg_match("/^{$key}=.*/m", $content)) {
                // Update existing key
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                // Append new key
                $content .= "\n{$key}={$value}";
            }
        }

        file_put_contents($path, $content);
    }
}
