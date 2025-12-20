<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Admin Panel - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                        "card-light": "#ffffff",
                        "card-dark": "#161e2c",
                        "border-light": "#e2e8f0",
                        "border-dark": "#232f48",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }

        // Check local storage or system preference, default to dark
        if (localStorage.theme === 'dark' || (!('theme' in localStorage))) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display antialiased selection:bg-primary/30 selection:text-primary transition-colors duration-200">
    <div class="relative min-h-screen flex flex-col overflow-hidden">
        <header class="sticky top-0 z-50 w-full border-b border-border-light dark:border-border-dark bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md">
            <div class="w-full px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-primary/20">
                        H
                    </div>
                    <h2 class="hidden sm:block text-lg font-bold tracking-tight">{{ config('app.name') }} <span class="text-slate-400 font-normal ml-2 text-sm bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">{{ __('messages.admin_badge') }}</span></h2>
                </div>
                <nav class="hidden md:flex items-center gap-6 lg:gap-8">
                    <a class="text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="{{ route('home') }}" target="_blank">{{ __('messages.admin_live_site') }}</a>
                </nav>
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex items-center bg-slate-200 dark:bg-slate-800 rounded-lg p-0.5">
                        <!-- Locale Switcher for Admin (same logic as public) -->
                        <a href="{{ route('set-locale', 'en') }}" class="px-2 py-1 rounded text-xs font-bold transition-all {{ app()->getLocale() === 'en' ? 'bg-white dark:bg-slate-600 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">EN</a>
                        <a href="{{ route('set-locale', 'tr') }}" class="px-2 py-1 rounded text-xs font-bold transition-all {{ app()->getLocale() === 'tr' ? 'bg-white dark:bg-slate-600 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">TR</a>
                    </div>
                    <button class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-lg transition-colors" title="Toggle Theme" onclick="toggleTheme()">
                        <span class="material-symbols-outlined hidden dark:block text-xl">light_mode</span>
                        <span class="material-symbols-outlined block dark:hidden text-xl">dark_mode</span>
                    </button>
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-xl">menu</span>
                    </button>
                    <div class="h-9 w-9 bg-primary/20 rounded-full flex items-center justify-center text-primary font-bold hidden sm:flex">
                        A
                    </div>
                </div>
            </div>
        </header>
        <div class="flex flex-1 overflow-hidden" x-data="{ sidebarOpen: false }">
            <!-- Mobile Sidebar Backdrop -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col border-r border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:w-64 transform">
                <div class="flex items-center justify-between p-4 lg:hidden border-b border-border-light dark:border-border-dark">
                    <span class="font-bold text-lg">{{ __('messages.admin_menu') }}</span>
                    <button @click="sidebarOpen = false" class="text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="p-4 space-y-1 overflow-y-auto flex-1">

                    <a class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors" href="{{ route('admin.dashboard') }}">
                        <span class="material-symbols-outlined text-xl">dashboard</span>
                        {{ __('messages.admin_nav_dashboard') }}
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.blog.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors" href="{{ route('admin.blog.index') }}">
                        <span class="material-symbols-outlined text-xl">article</span>
                        {{ __('messages.admin_nav_blog') }}
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.projects.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors" href="{{ route('admin.projects.index') }}">
                        <span class="material-symbols-outlined text-xl">rocket_launch</span>
                        {{ __('messages.admin_nav_projects') }}
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.profile.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors" href="{{ route('admin.profile.index') }}">
                        <span class="material-symbols-outlined text-xl">settings</span>
                        {{ __('messages.admin_nav_settings') }}
                    </a>
                </div>
                <div class="mt-auto p-4 border-t border-border-light dark:border-border-dark">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            {{ __('messages.admin_sign_out') }}
                        </button>
                    </form>
                </div>
            </aside>
            <main class="flex-1 overflow-y-auto p-4 sm:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
