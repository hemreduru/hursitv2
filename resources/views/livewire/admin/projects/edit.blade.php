<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold tracking-tight">{{ $project ? __('messages.admin_edit_project') : __('messages.admin_create_project') }}</h1>
        <a href="{{ route('admin.projects.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
            &larr; {{ __('messages.admin_back_list') }}
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div class="space-y-4 md:col-span-2">
                <label class="block text-sm font-medium">{{ __('messages.admin_title') }}</label>
                <input wire:model="title" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_slug') }}</label>
                <input wire:model="slug" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
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
                <label class="block text-sm font-medium">{{ __('messages.admin_content') }} (Markdown/HTML)</label>
                <textarea wire:model="content" rows="15" class="w-full font-mono text-sm rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark"></textarea>
                 @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

             <div class="space-y-4 md:col-span-2">
                <label class="block text-sm font-medium">{{ __('messages.admin_tech_stack') }}</label>
                <input wire:model="tech_stack_string" type="text" placeholder="{{ __('messages.admin_tech_stack_ph') }}" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_repo_url') }}</label>
                <input wire:model="url_repo" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_live_url') }}</label>
                <input wire:model="url_live" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

            <div class="space-y-4 md:col-span-2">
                <div class="flex items-center gap-3">
                    <input wire:model="is_featured" type="checkbox" id="is_featured" class="rounded border-border-light dark:border-border-dark bg-white dark:bg-card-dark text-primary focus:ring-primary">
                    <label for="is_featured" class="text-sm font-medium">{{ __('messages.admin_feature_homepage') }}</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-border-light dark:border-border-dark">
            <button type="submit" class="flex items-center gap-2 bg-primary hover:bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-primary/20 transition-all active:scale-95">
                <span class="material-symbols-outlined">save</span>
                {{ __('messages.admin_save_project') }}
            </button>
        </div>
         @if (session()->has('message'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
