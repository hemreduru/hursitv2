<div class="relative min-h-screen flex flex-col overflow-x-hidden">
    @include('partials.navbar')

    <main class="flex-1 w-full px-4 py-10 sm:px-6 md:py-14 lg:px-10 xl:px-16">
        <div class="mx-auto w-full max-w-[1280px] grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-10">
            <article class="lg:col-span-8 prose prose-slate dark:prose-invert prose-lg xl:prose-xl max-w-none">
                <header class="not-prose mb-10 md:mb-12">
                    <div class="mb-6 flex flex-wrap items-center gap-3 text-sm">
                        <a class="flex items-center gap-1 font-medium text-slate-500 dark:text-slate-300 hover:text-primary transition-colors" href="{{ route('blog.index') }}">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            {{ __('messages.back_to_blog') }}
                        </a>
                        <span class="text-slate-300 dark:text-slate-600">|</span>
                        @foreach($post->tags->sortBy('name')->values() as $tag)
                            <span class="text-primary font-medium bg-primary/10 px-2.5 py-0.5 rounded-md">#{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <h1 class="text-3xl font-black tracking-tight leading-tight text-slate-900 dark:text-slate-100 md:text-4xl lg:text-5xl mb-6">
                        {{ $post->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 border-b border-border-light pb-8 text-sm text-slate-500 dark:border-border-dark dark:text-slate-300">
                        <div class="flex items-center gap-2">
                            <div class="size-8 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-800">
                                <span class="flex items-center justify-center w-full h-full bg-primary text-white font-bold">H</span>
                            </div>
                            <span class="font-medium text-slate-900 dark:text-slate-100">Hurşit Emre Duru</span>
                        </div>
                        <span class="size-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                        <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->format('M d, Y') }}</time>
                        <span class="size-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                        <span>{{ $post->reading_time }} {{ __('messages.min_read') }}</span>
                    </div>
                </header>

                <div class="space-y-6">
                    {!! $post->content !!}
                </div>

                @if($previousPost || $nextPost)
                    <section class="not-prose mt-12 border-t border-border-light dark:border-border-dark pt-8">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">{{ __('messages.continue_reading') }}</h2>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @if($previousPost)
                                <a href="{{ route('blog.show', $previousPost->slug) }}"
                                   class="group rounded-xl border border-border-light bg-white p-4 transition-colors hover:border-primary/50 dark:border-border-dark dark:bg-surface-dark">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-primary">{{ __('messages.previous_post') }}</p>
                                    <h3 class="mt-2 text-base font-semibold text-slate-900 transition-colors group-hover:text-primary dark:text-slate-100">{{ $previousPost->title }}</h3>
                                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $previousPost->published_at?->format('M d, Y') }}</p>
                                </a>
                            @endif

                            @if($nextPost)
                                <a href="{{ route('blog.show', $nextPost->slug) }}"
                                   class="group rounded-xl border border-border-light bg-white p-4 transition-colors hover:border-primary/50 dark:border-border-dark dark:bg-surface-dark">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-primary">{{ __('messages.next_post') }}</p>
                                    <h3 class="mt-2 text-base font-semibold text-slate-900 transition-colors group-hover:text-primary dark:text-slate-100">{{ $nextPost->title }}</h3>
                                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">{{ $nextPost->published_at?->format('M d, Y') }}</p>
                                </a>
                            @endif
                        </div>
                    </section>
                @endif
            </article>

            <aside class="lg:col-span-4">
                <div class="sticky top-24 rounded-2xl border border-border-light bg-white p-6 shadow-sm dark:border-border-dark dark:bg-surface-dark">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">{{ __('messages.latest_posts') }}</h2>

                    <div class="flex flex-col divide-y divide-border-light dark:divide-border-dark">
                        @forelse($latestPosts as $latestPost)
                            <a href="{{ route('blog.show', $latestPost->slug) }}" class="group py-4 first:pt-0 last:pb-0 block">
                                <h3 class="text-sm font-semibold leading-6 text-slate-900 transition-colors group-hover:text-primary dark:text-slate-100">{{ $latestPost->title }}</h3>
                                <div class="mt-1 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-300">
                                    <time datetime="{{ $latestPost->published_at?->format('Y-m-d') }}">{{ $latestPost->published_at?->format('M d, Y') }}</time>
                                    <span class="size-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                    <span>{{ $latestPost->reading_time }} {{ __('messages.min_read') }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500 dark:text-slate-300">{{ __('messages.no_recent_posts') }}</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </main>

    @include('partials.footer')
</div>
