<div class="max-w-6xl mx-auto space-y-8">
    <section>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">{{ __('messages.admin_dashboard') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('messages.admin_welcome') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl">
                 <h3 class="font-bold text-lg mb-2">{{ __('messages.admin_nav_projects') }}</h3>
                 <p class="text-slate-500 text-sm">{{ __('messages.admin_projects_manage') }}</p>
                 <a href="{{ route('admin.projects.index') }}" class="text-primary text-sm font-bold mt-4 inline-block hover:underline">{{ __('messages.admin_go_projects') }} &rarr;</a>
            </div>
             <div class="p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl">
                 <h3 class="font-bold text-lg mb-2">{{ __('messages.admin_nav_blog') }}</h3>
                 <p class="text-slate-500 text-sm">{{ __('messages.admin_blog_manage') }}</p>
                 <a href="{{ route('admin.blog.index') }}" class="text-primary text-sm font-bold mt-4 inline-block hover:underline">{{ __('messages.admin_go_blog') }} &rarr;</a>
            </div>
             <div class="p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl">
                 <h3 class="font-bold text-lg mb-2">{{ __('messages.admin_profile_header') }}</h3>
                 <p class="text-slate-500 text-sm">{{ __('messages.admin_profile_manage') }}</p>
                 <a href="{{ route('admin.profile.index') }}" class="text-primary text-sm font-bold mt-4 inline-block hover:underline">{{ __('messages.admin_edit_profile') }} &rarr;</a>
            </div>
        </div>
    </section>
</div>
