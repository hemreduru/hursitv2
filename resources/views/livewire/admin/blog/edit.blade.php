<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold tracking-tight">{{ $form->post ? __('messages.admin_edit_post') : __('messages.admin_create_post') }}</h1>
        <a href="{{ route('admin.blog.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
            &larr; {{ __('messages.admin_back_list') }}
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6" x-data="{ lang: 'tr' }">

        <!-- Language Tabs -->
        <div class="flex gap-2 border-b border-border-light dark:border-border-dark pb-4 overflow-x-auto">
            <button type="button" @click="lang = 'tr'" :class="lang === 'tr' ? 'bg-primary/10 text-primary border-primary ring-1 ring-primary' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white border-transparent hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-lg font-bold text-sm border transition-all flex items-center gap-2">
                <span class="text-lg">TR</span> {{ __('messages.language_tr') }}
            </button>
            <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-primary/10 text-primary border-primary ring-1 ring-primary' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white border-transparent hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-4 py-2 rounded-lg font-bold text-sm border transition-all flex items-center gap-2">
                <span class="text-lg">EN</span> {{ __('messages.language_en') }}
            </button>
        </div>

        <!-- TR Section -->
        <div x-show="lang === 'tr'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_title') }} (TR) <span class="text-red-500">*</span></label>
                    <input wire:model.live.debounce.500ms="form.title_tr" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                    @error('form.title_tr') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_slug') }} (TR) <span class="text-red-500">*</span></label>
                    <input wire:model="form.slug_tr" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                     @error('form.slug_tr') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4 md:col-span-2">
                    <label class="block text-sm font-medium">{{ __('messages.admin_short_desc') }} (TR) <span class="text-red-500">*</span></label>
                    <textarea wire:model="form.short_description_tr" rows="3" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all"></textarea>
                     @error('form.short_description_tr') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4 md:col-span-2">
                    <x-rich-text id="content_tr" label="{{ __('messages.admin_content') }} (TR)" wire:model="form.content_tr" />
                     @error('form.content_tr') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4 md:col-span-2">
                    <x-select2 id="tags_tr" label="{{ __('messages.admin_tags') }} (TR)" wire:model="form.selectedTagsTr" multiple>
                        @foreach($tagsTr as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </x-select2>
                </div>
            </div>
        </div>

        <!-- EN Section -->
        <div x-show="lang === 'en'" class="space-y-6" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_title') }} (EN) <span class="text-red-500">*</span></label>
                    <input wire:model.live.debounce.500ms="form.title_en" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                    @error('form.title_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_slug') }} (EN) <span class="text-red-500">*</span></label>
                    <input wire:model="form.slug_en" type="text" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                     @error('form.slug_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4 md:col-span-2">
                    <label class="block text-sm font-medium">{{ __('messages.admin_short_desc') }} (EN) <span class="text-red-500">*</span></label>
                    <textarea wire:model="form.short_description_en" rows="3" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all"></textarea>
                     @error('form.short_description_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4 md:col-span-2">
                    <x-rich-text id="content_en" label="{{ __('messages.admin_content') }} (EN)" wire:model="form.content_en" />
                     @error('form.content_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4 md:col-span-2">
                    <x-select2 id="tags_en" label="{{ __('messages.admin_tags') }} (EN)" wire:model="form.selectedTagsEn" multiple>
                        @foreach($tagsEn as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </x-select2>
                </div>
            </div>
        </div>

        <!-- Shared Section -->
        <div class="pt-6 border-t border-border-light dark:border-border-dark">
             <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">settings_suggest</span>
                {{ __('messages.admin_settings') }}
             </h3>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_status') }}</label>
                    <select wire:model="form.status" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                        <option value="draft">{{ __('messages.status_draft') }}</option>
                        <option value="published">{{ __('messages.status_published') }}</option>
                    </select>
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_published_at') }}</label>
                <!-- NOTE: datetime-local needs format YYYY-MM-DDTHH:MM, ensure backend sends it or Livewire formats it -->
                    <input wire:model="form.published_at" type="datetime-local" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-medium">{{ __('messages.admin_reading_time') }}</label>
                    <input wire:model="form.reading_time" type="number" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark focus:ring-primary focus:border-primary transition-all">
                </div>

<!-- Removed shared tags input -->
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
        @if (session()->has('error'))
            <div class="p-4 bg-red-100 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
    </form>
</div>
