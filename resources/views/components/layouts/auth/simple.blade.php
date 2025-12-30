<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <script>
            // Check local storage or system preference, default to dark
            if (localStorage.theme === 'dark' || (!('theme' in localStorage))) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="min-h-screen bg-background-light dark:bg-background-dark font-display antialiased text-slate-900 dark:text-white selection:bg-primary/30 selection:text-primary transition-colors duration-200 flex flex-col items-center justify-center p-6 md:p-10">

        <div class="w-full max-w-sm flex flex-col gap-8">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium transition-transform hover:scale-105" wire:navigate>
                <div class="size-12 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-xl shadow-primary/20">
                    H
                </div>
                <span class="text-xl font-bold tracking-tight mt-2">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl shadow-xl p-6 sm:p-8">
                {{ $slot }}
            </div>

            <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
            </p>
        </div>

        @fluxScripts
        @if(config('services.recaptcha.site_key'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        @endif
    </body>
</html>
