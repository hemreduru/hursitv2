<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    @include('partials.navbar')

    <main class="flex-1 px-4 py-8 lg:px-40 lg:py-12 flex justify-center">
        <div class="w-full max-w-[800px] flex flex-col gap-8">
            <div class="flex flex-col gap-2 pb-4">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900 dark:text-white">{{ __('messages.blog_title') }}</h1>
                <p class="text-lg text-slate-600 dark:text-slate-400">{{ __('messages.blog_desc') }}</p>
            </div>

            <!-- Search and Filter Row (Placeholder for future implementation) -->
            <div class="flex flex-col gap-6 sticky top-20 z-40 py-2 bg-background-light dark:bg-background-dark -mx-4 px-4 lg:-mx-0 lg:px-0">
                 <!-- Currently static placeholder in HTML, simplified here -->
                <div class="relative w-full group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input class="block w-full rounded-xl border-none bg-white dark:bg-surface-dark py-3 pl-10 pr-4 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary shadow-sm" placeholder="{{ __('messages.search_placeholder') }}" type="text"/>
                </div>
            </div>

            <div class="flex flex-col gap-6 mt-2">
                @forelse($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="group flex flex-col sm:flex-row gap-6 p-6 rounded-2xl bg-white dark:bg-surface-dark border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all shadow-sm hover:shadow-md cursor-pointer">
                    <div class="flex-1 flex flex-col gap-3">
                        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wider text-primary">
                            @foreach($post->tags->take(1) as $tag)
                            <span>{{ $tag->name }}</span>
                            @endforeach
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span class="text-slate-500 dark:text-slate-400 font-normal normal-case">{{ $post->published_at->format('M d, Y') }}</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                            {{ $post->title }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-2">
                            {{ $post->short_description }}
                        </p>
                    </div>
                    <div class="shrink-0 hidden sm:flex items-center justify-center">
                        <span class="material-symbols-outlined text-slate-300 dark:text-slate-600 group-hover:text-primary transition-colors text-3xl">chevron_right</span>
                    </div>
                </a>
                @empty
                    <p class="text-slate-500">{{ __('messages.no_posts_found') }}</p>
                @endforelse
            </div>
        </div>
    </main>

    @include('partials.footer')
</div>
