<?php

use App\Livewire\Public\Home\Index as HomeIndex;
use App\Livewire\Public\Projects\Index as ProjectsIndex;
use App\Livewire\Public\Projects\Show as ProjectShow;
use App\Livewire\Public\Blog\Index as BlogIndex;
use App\Livewire\Public\Blog\Show as BlogPost;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Blog\Index as AdminBlogIndex;
use App\Livewire\Admin\Blog\Edit as AdminBlogEdit;
use App\Livewire\Admin\Projects\Index as AdminProjectsIndex;
use App\Livewire\Admin\Projects\Edit as AdminProjectsEdit;
use App\Livewire\Admin\Tags\Index as AdminTagsIndex;
use App\Livewire\Admin\Tags\Edit as AdminTagsEdit;
use App\Livewire\Admin\Profile\Index as AdminProfileIndex;
use App\Livewire\Admin\Profile\Edit as AdminProfileEdit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Language Switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'tr'])) {
        Session::put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('set-locale');

Route::middleware([\App\Http\Middleware\SetLocale::class])->group(function () {
    Route::get('/', HomeIndex::class)->name('home');
    Route::get('/projects', ProjectsIndex::class)->name('projects.index');
    Route::get('/projects/{slug}', ProjectShow::class)->name('projects.show');
    Route::get('/blog', BlogIndex::class)->name('blog.index');
    Route::get('/blog/{slug}', BlogPost::class)->name('blog.show');
});

// Admin Routes
Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
    \App\Http\Middleware\SetLocale::class,
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

    // Blog
    Route::get('/blog', AdminBlogIndex::class)->name('blog.index');
    Route::get('/blog/create', AdminBlogEdit::class)->name('blog.create');
    Route::get('/blog/{id}/edit', AdminBlogEdit::class)->name('blog.edit');

    // Projects
    Route::get('/projects', AdminProjectsIndex::class)->name('projects.index');
    Route::get('/projects/create', AdminProjectsEdit::class)->name('projects.create');
    Route::get('/projects/{id}/edit', AdminProjectsEdit::class)->name('projects.edit');

    // Tags
    Route::get('/tags', AdminTagsIndex::class)->name('tags.index');
    Route::get('/tags/create', AdminTagsEdit::class)->name('tags.create');
    Route::get('/tags/{id}/edit', AdminTagsEdit::class)->name('tags.edit');

    // Profile Settings
    Route::get('/profile', AdminProfileIndex::class)->name('profile.index');
    Route::get('/profile/create', AdminProfileEdit::class)->name('profile.create');
    Route::get('/profile/{id}/edit', AdminProfileEdit::class)->name('profile.edit');
});
