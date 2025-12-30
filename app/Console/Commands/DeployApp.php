<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeployApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application (migrate, cache, optimize).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting deployment process...');

        if ($this->option('force') || $this->confirm('Do you want to configure project details (App Name, URL, Locale)?', true)) {
            $this->setupWizard();
        }

        $this->info('Starting automated deployment tasks...');

        // 1. Migrate Database
        $this->info('Migrating database...');
        $this->call('migrate', ['--force' => true]);

        // 2. Clear & Cache Config
        $this->info('Caching configuration...');
        $this->call('config:cache');

        // 3. Cache Routes
        $this->info('Caching routes...');
        $this->call('route:cache');

        // 4. Cache Views
        $this->info('Caching views...');
        $this->call('view:cache');

        // 5. Optimize Autoloader (Composer) - Optional/Shell exec
        $this->info('Optimizing autoloader...');
        shell_exec('composer install --no-dev --optimize-autoloader');

        // 6. Build Assets (NPM) - Optional/Shell exec
        $this->info('Building assets...');
        shell_exec('npm run build');

        // 7. Restart Queue (if applicable)
        $this->call('queue:restart');

        $this->info('Deployment completed successfully! 🚀');
        return 0;
    }

    private function setupWizard()
    {
        $appName = $this->ask('Application Name', config('app.name'));
        $appUrl = $this->ask('Application URL', config('app.url'));
        $appLocale = $this->choice('Default Language', ['tr', 'en'], config('app.locale'));

        $this->updateEnvironmentFile([
            'APP_NAME' => '"' . $appName . '"',
            'APP_URL' => $appUrl,
            'APP_LOCALE' => $appLocale,
        ]);

        $this->info('Configuration updated.');
        // Clear config cache immediately to reflect changes for subsequent steps
        $this->call('config:clear');
    }

    private function updateEnvironmentFile(array $data)
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            return;
        }

        $content = file_get_contents($path);

        foreach ($data as $key => $value) {
            if (preg_match("/^{$key}=.*/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}";
            }
        }

        file_put_contents($path, $content);
    }
}
