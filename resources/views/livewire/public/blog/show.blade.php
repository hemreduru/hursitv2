<div class="relative min-h-screen flex flex-col overflow-x-hidden">
    @include('partials.navbar')

    <main class="flex-1 w-full max-w-[800px] mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 flex flex-col">
        <article class="prose prose-slate dark:prose-invert prose-lg max-w-none">
            <header class="not-prose mb-10 md:mb-14">
                <div class="mb-6 flex flex-wrap items-center gap-3 text-sm">
                    <a class="flex items-center gap-1 font-medium text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="{{ route('blog.index') }}">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        {{ __('messages.back_to_blog') }}
                    </a>
                    <span class="text-slate-300 dark:text-slate-700">|</span>
                    @foreach($post->tags as $tag)
                    <span class="text-primary font-medium bg-primary/10 px-2.5 py-0.5 rounded-md">#{{ $tag->name }}</span>
                    @endforeach
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-6">
                    {{ $post->title }}
                </h1>
                <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400 border-b border-border-light dark:border-border-dark pb-8">
                    <div class="flex items-center gap-2">
                        <div class="size-8 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-800">
                             <!-- Placeholder avatar if no user relation yet -->
                             <span class="flex items-center justify-center w-full h-full bg-primary text-white font-bold">H</span>
                        </div>
                        <span class="font-medium text-slate-900 dark:text-white">Hurşit Emre Duru</span>
                    </div>
                    <span class="size-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                    <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->format('M d, Y') }}</time>
                    <span class="size-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                    <span>{{ $post->reading_time }} {{ __('messages.min_read') }}</span>
                </div>
            </header>
            <div class="space-y-6">
                <!-- Content - Assumed HTML or Markdown processed before saving or use a parser here. For now raw output -->
                {!! $post->content !!}
            </div>
        </article>
    </main>

    @include('partials.footer')
</div>
