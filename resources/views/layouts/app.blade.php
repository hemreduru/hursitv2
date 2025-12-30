<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display antialiased selection:bg-primary/30 selection:text-primary transition-colors duration-200">
    <div id="app">
        {{ $slot }}
    </div>

    @include('partials.scripts')
</body>
</html>
