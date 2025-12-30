<div class="relative min-h-screen flex flex-col overflow-x-hidden">
    @include('partials.navbar')

    <main class="flex-1 w-full max-w-[960px] mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 flex flex-col gap-24 md:gap-32">
        <!-- Hero Section -->
        <section class="flex flex-col-reverse md:flex-row items-center gap-10 md:gap-16" id="about">
            <div class="flex-1 flex flex-col gap-6 text-center md:text-left">
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold tracking-wide uppercase">{{ __('messages.available_for_hire') }}</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1]">
                        {{ $profile->name ?? 'Hurşit Emre Duru' }} <span class="text-primary">{{ $profile->title ?? 'Engineer' }}</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-xl mx-auto md:mx-0 leading-relaxed">
                        {{ $profile->bio ?? 'I build accessible, pixel-perfect, and performant web experiences. Focused on scalable solutions using React, Node.js, and modern cloud architecture.' }}
                    </p>
                </div>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <a class="h-11 px-6 rounded-lg bg-primary text-white font-bold text-sm flex items-center justify-center hover:bg-blue-600 transition-all shadow-lg shadow-primary/25 active:scale-95" href="#contact">
                        {{ __('messages.get_in_touch') }}
                    </a>
                    <a class="h-11 px-6 rounded-lg bg-white dark:bg-card-dark border border-border-light dark:border-border-dark text-slate-900 dark:text-white font-bold text-sm flex items-center justify-center hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95" href="{{ route('projects.index') }}">
                        {{ __('messages.view_projects') }}
                    </a>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-1 mt-2">
                     @if(isset($profile) && $profile->social_links)
                        @foreach($profile->social_links as $platform => $url)
                             <a class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors p-2" href="{{ $url }}" target="_blank">
                                <span class="sr-only">{{ ucfirst($platform) }}</span>
                                <i class="fa-brands fa-{{ strtolower($platform) }} text-xl"></i>
                             </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="relative w-40 h-40 md:w-64 md:h-64 shrink-0">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary to-purple-500 rounded-full blur-2xl opacity-50 dark:opacity-40 animate-pulse"></div>
                <div class="relative w-full h-full rounded-full border-4 border-white dark:border-card-dark shadow-2xl overflow-hidden bg-background-light dark:bg-background-dark">
                    <img alt="{{ $profile->name ?? '' }}" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhn6F-r5kj-lHABNLLI8eH_Wn3yBXsi-LyHYZvTV1lzgCRlM4Kzh9gxEfQlCfX6olJ6sPfVDU4iaEDczIIzEjKZdVaBEJvrjVVXeYH63Hxi5tuhh7l0_6oXPXfXMwud_HsGiPxVH_HVVdMUrpu7Pe73NmjO5D-JCq42w9rEzFE0l9TD15DU_5q1d1bFT-E5DEEgp3n8HEi0eZnfCVSY8_-NlwQwswKOu7Jj9DKosX2-zLDz2iqGyUgnGnmGpWMwdiPoyQuefUU4JY"/>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        @if($skills && $skills->count() > 0)
        <section class="space-y-6" id="skills">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">code</span>
                <h2 class="text-2xl font-bold tracking-tight">{{ __('messages.technical_skills') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($skills as $category => $categorySkills)
                <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark p-5 rounded-xl">
                    <h3 class="font-semibold mb-4 text-slate-500 dark:text-slate-400 text-sm uppercase tracking-wider">{{ $category }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categorySkills as $skill)
                            <span class="px-3 py-1 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg text-sm font-medium">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Experience Section -->
        @if($experiences && $experiences->count() > 0)
        <section class="space-y-8" id="experience">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-3xl">work_history</span>
                <h2 class="text-2xl font-bold tracking-tight">{{ __('messages.work_experience') }}</h2>
            </div>
            <div class="relative border-l-2 border-border-light dark:border-border-dark ml-3 space-y-12">
                @foreach($experiences as $xp)
                <div class="relative pl-10">
                    <div class="absolute -left-[9px] top-2 size-4 {{ $loop->first ? 'bg-primary' : 'bg-slate-300 dark:bg-slate-700' }} rounded-full ring-4 ring-background-light dark:ring-background-dark"></div>
                    <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between mb-2">
                        <h3 class="text-xl font-bold">{{ $xp->role }}</h3>
                        <span class="text-sm font-mono text-slate-500 dark:text-slate-400">{{ $xp->date_range }}</span>
                    </div>
                    <div class="text-primary font-medium mb-4">{{ $xp->company }}</div>
                    <div class="prose prose-sm dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed">
                        {!! nl2br(e($xp->description)) !!}
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Projects Section -->
        <section class="space-y-8" id="projects">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl">rocket_launch</span>
                    <h2 class="text-2xl font-bold tracking-tight">{{ __('messages.featured_projects') }}</h2>
                </div>
                <a class="text-sm font-bold text-primary hover:text-blue-400 flex items-center gap-1" href="{{ route('projects.index') }}">
                    {{ __('messages.view_all') }} <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($featuredProjects as $project)
                <div class="group bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl overflow-hidden hover:border-primary/50 transition-colors shadow-sm hover:shadow-md">
                    <div class="h-48 w-full bg-slate-800 relative overflow-hidden">
                        <!-- Placeholder image if no image field in DB yet, but design had one. For now using static or color -->
                         <div class="absolute inset-0 bg-gradient-to-tr from-primary to-purple-500 opacity-20"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-card-dark to-transparent opacity-60"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors">{{ $project->title }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">
                            {{ $project->short_description }}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            @if($project->tech_stack)
                                @foreach($project->tech_stack as $tech)
                                    <span class="text-xs font-semibold px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded text-slate-600 dark:text-slate-300">{{ $tech }}</span>
                                @endforeach
                            @endif
                        </div>
                        <a class="inline-flex items-center text-sm font-bold text-slate-900 dark:text-white hover:text-primary transition-colors" href="{{ route('projects.show', $project->slug) }}">
                            {{ __('messages.view_project') }} <span class="material-symbols-outlined text-lg ml-1">arrow_outward</span>
                        </a>
                    </div>
                </div>
                @empty
                 <p class="text-slate-500">{{ __('messages.no_projects_found') }}</p>
                @endforelse
            </div>
        </section>

        <!-- Blog Section -->
        <section class="space-y-8" id="blog">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl">article</span>
                    <h2 class="text-2xl font-bold tracking-tight">{{ __('messages.latest_writings') }}</h2>
                </div>
                <a class="text-sm font-bold text-primary hover:text-blue-400 flex items-center gap-1" href="{{ route('blog.index') }}">
                    {{ __('messages.view_all') }} <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="space-y-4">
                @forelse($latestPosts as $post)
                <a class="block group p-5 rounded-xl border border-transparent hover:border-border-light dark:hover:border-border-dark hover:bg-card-light dark:hover:bg-card-dark transition-all" href="{{ route('blog.show', $post->slug) }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-1">
                        <h3 class="text-lg font-bold group-hover:text-primary transition-colors">{{ $post->title }}</h3>
                        <span class="text-xs font-mono text-slate-400">{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm max-w-2xl mb-3">
                        {{ $post->short_description }}
                    </p>
                    <div class="flex gap-2">
                         @foreach($post->tags as $tag)
                            <span class="text-xs text-primary font-medium bg-primary/10 px-2 py-0.5 rounded">#{{ $tag->name }}</span>
                         @endforeach
                        <span class="text-xs text-slate-500 font-medium">{{ $post->reading_time }} {{ __('messages.min_read') }}</span>
                    </div>
                </a>
                @empty
                    <p class="text-slate-500">{{ __('messages.no_posts_found') }}</p>
                @endforelse
            </div>
        </section>

        <!-- Contact Section -->
        <section class="pt-10 border-t border-border-light dark:border-border-dark" id="contact">
            <div class="flex flex-col items-center text-center gap-6">
                <h2 class="text-2xl font-bold">{{ __('messages.lets_work_together') }}</h2>
                <p class="text-slate-600 dark:text-slate-400 max-w-md">
                     {{ $profile->bio ?? 'I\'m currently available for freelance projects or full-time opportunities. Drop me a line if you\'d like to chat.' }}
                </p>
                <a class="text-xl font-medium text-primary hover:underline underline-offset-4 decoration-2" href="mailto:{{ $profile->contact_email ?? 'hello@example.com' }}">
                    {{ $profile->contact_email ?? 'hello@example.com' }}
                </a>
                <div class="mt-8 text-sm text-slate-500">
                    © {{ date('Y') }} {{ $profile->name ?? 'Hurşit Emre Duru' }}. {{ __('messages.built_with') }}
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</div>
