@php
    $currentRoute = Route::currentRouteName();
    $locales = ['en', 'tr'];
    $currentLocale = app()->getLocale();
@endphp

<header class="sticky top-0 z-50 w-full border-b border-border-light dark:border-border-dark bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md"
    x-data="{ mobileMenuOpen: false }">
    <div class="w-full max-w-[960px] mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="size-10 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-primary/20 hover:bg-blue-600 transition-colors">
                H
            </a>
            <h2 class="hidden sm:block text-lg font-bold tracking-tight">Hurşit Emre Duru</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6 lg:gap-8">
            <a class="text-sm font-medium transition-colors {{ $currentRoute === 'home' ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('home') }}">
                {{ __('messages.home') }}
            </a>
            <a class="text-sm font-medium transition-colors {{ $currentRoute === 'projects.index' ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('projects.index') }}">
                {{ __('messages.work') }}
            </a>
            <a class="text-sm font-medium transition-colors {{ $currentRoute === 'blog.index' ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('blog.index') }}">
                {{ __('messages.blog') }}
            </a>
        </nav>
        <div class="flex items-center gap-3 md:gap-4">
            <div class="flex items-center bg-slate-200 dark:bg-slate-800 rounded-lg p-0.5">
                <a href="{{ route('set-locale', 'en') }}"
                   class="px-2 py-1 rounded text-xs font-bold transition-all {{ $currentLocale === 'en' ? 'bg-white dark:bg-slate-600 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                   EN
                </a>
                <a href="{{ route('set-locale', 'tr') }}"
                   class="px-2 py-1 rounded text-xs font-bold transition-all {{ $currentLocale === 'tr' ? 'bg-white dark:bg-slate-600 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                   TR
                </a>
            </div>

            <!-- Theme Toggle -->
            <button
                x-data
                @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-lg transition-colors"
                title="{{ __('messages.theme_toggle_title') }}"
            >
                <span class="material-symbols-outlined hidden dark:block text-xl">light_mode</span>
                <span class="material-symbols-outlined block dark:hidden text-xl">dark_mode</span>
            </button>
            <script>
                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
            </script>

            <button class="hidden md:flex h-9 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-lg shadow-primary/25 hover:bg-blue-600 transition-all active:scale-95">
                {{ __('messages.download_cv') }}
            </button>
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 dark:text-slate-300">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" class="md:hidden bg-background-light dark:bg-background-dark border-b border-border-light dark:border-border-dark p-4">
         <nav class="flex flex-col gap-4">
            <a class="text-sm font-medium transition-colors hover:text-primary" href="{{ route('home') }}">{{ __('messages.home') }}</a>
            <a class="text-sm font-medium transition-colors hover:text-primary" href="{{ route('projects.index') }}">{{ __('messages.work') }}</a>
            <a class="text-sm font-medium transition-colors hover:text-primary" href="{{ route('blog.index') }}">{{ __('messages.blog') }}</a>
         </nav>
    </div>
</header>
