<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold tracking-tight">{{ $post ? __('messages.admin_edit_post') : __('messages.admin_create_post') }}</h1>
        <a href="{{ route('admin.blog.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
            &larr; {{ __('messages.admin_back_list') }}
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4 md:col-span-2">
                <label class="block text-sm font-medium">{{ __('messages.admin_title') }}</label>
                <input wire:model="title" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark" placeholder="{{ __('messages.admin_title') }}">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_slug') }}</label>
                <input wire:model="slug" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark" placeholder="post-slug">
                 @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_lang') }}</label>
                <select wire:model="locale" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
                    <option value="en">English (EN)</option>
                    <option value="tr">Turkish (TR)</option>
                </select>
            </div>

             <div class="space-y-4 md:col-span-2">
                <label class="block text-sm font-medium">{{ __('messages.admin_short_desc') }}</label>
                <textarea wire:model="short_description" rows="3" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark"></textarea>
                 @error('short_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

             <div class="space-y-4 md:col-span-2">
                <label class="block text-sm font-medium">{{ __('messages.admin_content') }}</label>
                <textarea wire:model="content" rows="15" class="w-full font-mono text-sm rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark"></textarea>
                 @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_status') }}</label>
                <select wire:model="status" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

             <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_published_at') }}</label>
                <input wire:model="published_at" type="datetime-local" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

             <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_reading_time') }}</label>
                <input wire:model="reading_time" type="number" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

             <div class="space-y-4">
                <x-select2 label="{{ __('messages.admin_tags') }}" wire:model="selectedTags" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }} ({{ $tag->locale }})</option>
                    @endforeach
                </x-select2>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-border-light dark:border-border-dark">
            <button type="submit" class="flex items-center gap-2 bg-primary hover:bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-primary/20 transition-all active:scale-95">
                <span class="material-symbols-outlined">save</span>
                {{ __('messages.admin_save') }}
            </button>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
