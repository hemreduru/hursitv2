<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold tracking-tight">{{ $form->profile ? __('messages.admin_edit_profile') : __('messages.admin_create_profile') }}</h1>
        <a href="{{ route('admin.profile.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
            &larr; {{ __('messages.admin_back_list') }}
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6" x-data="{ lang: 'tr' }">

        <!-- Language Tabs -->
        <div class="flex gap-2 border-b border-border-light dark:border-border-dark pb-4 overflow-x-auto">
            <button type="button" @click="lang = 'tr'" :class="lang === 'tr' ? 'bg-primary/10 text-primary border-primary ring-1 ring-primary' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white border-transparent hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-lg font-bold text-sm border transition-all flex items-center gap-2">
                <span class="text-lg">🇹🇷</span> Türkçe
            </button>
            <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-primary/10 text-primary border-primary ring-1 ring-primary' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white border-transparent hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-lg font-bold text-sm border transition-all flex items-center gap-2">
                <span class="text-lg">🇬🇧</span> English
            </button>
        </div>

        <!-- TR Section -->
        <div x-show="lang === 'tr'" class="space-y-4">
             <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_job_title') }} (TR) <span class="text-red-500">*</span></label>
                <input wire:model="form.title_tr" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                 @error('form.title_tr') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_bio') }} (TR) <span class="text-red-500">*</span></label>
                <textarea wire:model="form.bio_tr" rows="4" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all"></textarea>
                @error('form.bio_tr') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- EN Section -->
        <div x-show="lang === 'en'" style="display:none;" class="space-y-4">
             <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_job_title') }} (EN) <span class="text-red-500">*</span></label>
                <input wire:model="form.title_en" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                 @error('form.title_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-4">
                <label class="block text-sm font-medium">{{ __('messages.admin_bio') }} (EN) <span class="text-red-500">*</span></label>
                <textarea wire:model="form.bio_en" rows="4" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all"></textarea>
                @error('form.bio_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Shared Section -->
        <div class="pt-6 border-t border-border-light dark:border-border-dark space-y-6">
            <h3 class="text-lg font-bold flex items-center gap-2">
                <span class="material-symbols-outlined">person</span>
                {{ __('messages.admin_settings') }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_name') }}</label>
                    <input wire:model="form.name" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                    @error('form.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_contact_email') }}</label>
                    <input wire:model="form.contact_email" type="email" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                     @error('form.contact_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-border-light dark:border-border-dark space-y-4">
                <h3 class="font-bold text-lg">{{ __('messages.admin_social_links') }}</h3>

                <div class="space-y-2">
                    <label class="block text-sm font-medium">Github URL</label>
                    <input wire:model="form.github_url" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all" placeholder="https://github.com/username">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium">LinkedIn URL</label>
                    <input wire:model="form.linkedin_url" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all" placeholder="https://linkedin.com/in/username">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium">X / Twitter URL</label>
                    <input wire:model="form.twitter_url" type="url" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all" placeholder="https://x.com/username">
                </div>
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
