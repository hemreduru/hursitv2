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
        $this->info('Starting deployment...');

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
}
