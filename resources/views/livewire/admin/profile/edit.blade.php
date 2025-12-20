<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold tracking-tight">{{ $profile ? __('messages.admin_edit_profile') : __('messages.admin_create_profile') }}</h1>
        <a href="{{ route('admin.profile.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
            &larr; {{ __('messages.admin_back_list') }}
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="space-y-4">
            <label class="block text-sm font-medium">{{ __('messages.admin_name') }}</label>
            <input wire:model="name" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium">{{ __('messages.admin_job_title') }}</label>
            <input wire:model="title" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark" placeholder="e.g. Senior Full-Stack Engineer">
             @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium">{{ __('messages.admin_contact_email') }}</label>
            <input wire:model="contact_email" type="email" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
             @error('contact_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium">{{ __('messages.admin_bio') }}</label>
            <textarea wire:model="bio" rows="4" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark"></textarea>
            @error('bio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-4">
            <label class="block text-sm font-medium">{{ __('messages.admin_lang') }}</label>
            <select wire:model="locale" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
                <option value="en">English (EN)</option>
                <option value="tr">Turkish (TR)</option>
            </select>
        </div>

        <div class="pt-4 border-t border-border-light dark:border-border-dark space-y-4">
            <h3 class="font-bold text-lg">{{ __('messages.admin_social_links') }}</h3>

            <div class="space-y-2">
                <label class="block text-sm font-medium">Github URL</label>
                <input wire:model="github_url" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium">LinkedIn URL</label>
                <input wire:model="linkedin_url" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium">X / Twitter URL</label>
                <input wire:model="twitter_url" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark">
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-border-light dark:border-border-dark">
            <button type="submit" class="flex items-center gap-2 bg-primary hover:bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-primary/20 transition-all active:scale-95">
                <span class="material-symbols-outlined">save</span>
                {{ __('messages.admin_save_profile') }}
            </button>
        </div>
         @if (session()->has('message'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
