<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $title ?? 'Hurşit Emre Duru - Senior Full-Stack Engineer' }}</title>
<meta name="description" content="{{ $meta_description ?? 'Freelance Full-Stack Engineer specializing in scalable web applications with Laravel, Livewire, and TailwindCSS.' }}">
<meta name="keywords" content="{{ $meta_keywords ?? 'Laravel, Livewire, TailwindCSS, Full-Stack, Web Development, Turkce, English' }}">
<meta name="author" content="Hurşit Emre Duru">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $og_type ?? 'website' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ?? 'Hurşit Emre Duru - Senior Full-Stack Engineer' }}">
<meta property="og:description" content="{{ $meta_description ?? 'Freelance Full-Stack Engineer specializing in scalable web applications.' }}">
<meta property="og:image" content="{{ $og_image ?? asset('images/og-default.jpg') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title ?? 'Hurşit Emre Duru - Senior Full-Stack Engineer' }}">
<meta property="twitter:description" content="{{ $meta_description ?? 'Freelance Full-Stack Engineer specializing in scalable web applications.' }}">
<meta property="twitter:image" content="{{ $og_image ?? asset('images/og-default.jpg') }}">

<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries,typography"></script>
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
                    "surface-light": "#ffffff",
                    "surface-dark": "#1e293b",
                },
                fontFamily: {
                    "display": ["Inter", "sans-serif"],
                    "mono": ["JetBrains Mono", "monospace"],
                    "body": ["Inter", "sans-serif"],
                },
                typography: (theme) => ({
                    DEFAULT: {
                        css: {
                            color: theme('colors.slate.600'),
                            '--tw-prose-headings': theme('colors.slate.900'),
                            '--tw-prose-links': theme('colors.primary'),
                            '--tw-prose-code': theme('colors.pink.600'),
                            '--tw-prose-pre-bg': theme('colors.slate.900'),
                            '--tw-prose-pre-code': theme('colors.slate.100'),
                        },
                    },
                    dark: {
                        css: {
                            color: theme('colors.slate.400'),
                            '--tw-prose-headings': theme('colors.white'),
                            '--tw-prose-links': theme('colors.blue.400'),
                            '--tw-prose-code': theme('colors.pink.400'),
                            '--tw-prose-pre-bg': '#1e293b',
                            '--tw-prose-pre-code': theme('colors.slate.200'),
                        },
                    },
                }),
                borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
        },
    }
</script>
<style>
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #101622;
    }
    ::-webkit-scrollbar-thumb {
        background: #232f48;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #324467;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
