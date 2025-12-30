<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Illuminate\Support\Facades\App;

class TestDualLanguage extends Command
{
    protected $signature = 'test:dual-language';
    protected $description = 'Verify dual language models';

    public function handle()
    {
        $this->info('Starting Dual Language Test...');

        // Cleanup
        Project::truncate();

        // Create
        $project = Project::create([
            'title_en' => 'English Title',
            'title_tr' => 'Turkish Title',
            'slug_en' => 'english-slug',
            'slug_tr' => 'turkish-slug',
            'short_description_en' => 'Short EN',
            'short_description_tr' => 'Short TR',
            'content_en' => 'Content EN',
            'content_tr' => 'Content TR',
            'is_featured' => true,
        ]);

        $this->info('Project created with ID: ' . $project->id);

        // Test EN (Default)
        App::setLocale('en');
        if ($project->title !== 'English Title') {
            $this->error('FAIL: Expected English Title, got: ' . $project->title);
            return 1;
        }
        $this->info('PASS: EN Title correct.');

        // Test TR
        App::setLocale('tr');
        // Reload model to ensure accessors catch the change if they rely on cached checks (usually they don't)
        // Actually accessors use app()->getLocale() dynamically.

        if ($project->title !== 'Turkish Title') {
             // Accessor logic check: $this->attributes['title_' . app()->getLocale()]
             $this->error('FAIL: Expected Turkish Title, got: ' . $project->title . ' (Locale: '.App::getLocale().')');
             return 1;
        }
        $this->info('PASS: TR Title correct.');

        $this->info('ALL SYSTEMS GO.');
        return 0;
    }
}
