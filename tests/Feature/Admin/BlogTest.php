<?php

use App\Models\User;
use App\Models\Post;
use Livewire\Livewire;
use App\Livewire\Admin\Blog\Index;
use App\Livewire\Admin\Blog\Edit;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('admin can view blog posts list', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Unique Test Post List',
        'title_en' => 'Unique Test Post List',
    ]);

    Livewire::test(Index::class)
        ->set('search', 'Unique Test Post List')
        ->assertStatus(200)
        ->assertSee('Unique Test Post List');
});

test('admin can create a new post', function () {
    $uniqueTitle = 'Unique New Post ' . uniqid();

    Livewire::test(Edit::class)
        ->set('form.title_tr', $uniqueTitle)
        ->set('form.title_en', 'New Post EN')
        ->set('form.content_tr', '<p>Test İçerik</p>')
        ->set('form.short_description_tr', 'Kısa')
        ->set('form.short_description_en', 'Short')
        ->set('form.content_en', '<p>Test Content</p>')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.blog.index'));

    expect(Post::where('title_tr', $uniqueTitle)->exists())->toBeTrue();

    $post = Post::where('title_tr', $uniqueTitle)->first();
    expect($post->slug_tr)->toBe(\Illuminate\Support\Str::slug($uniqueTitle))
        ->and($post->content_tr)->toBe('<p>Test İçerik</p>');
});

test('validation works for blog creation', function () {
    Livewire::test(Edit::class)
        ->set('form.title_tr', '')
        ->call('save')
        ->assertHasErrors(['form.title_tr']);
});

test('admin can update a post and change slugs', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Old Title',
        'slug_tr' => 'old-title'
    ]);

    $newTitle = 'New Unique Title ' . uniqid();

    Livewire::test(Edit::class, ['id' => $post->id])
        ->set('form.title_tr', $newTitle)
        ->call('save')
        ->assertHasNoErrors();

    $post->refresh();
    expect($post->title_tr)->toBe($newTitle)
        ->and($post->slug_tr)->toBe(\Illuminate\Support\Str::slug($newTitle));
});
