<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    @include('partials.navbar')

    <main class="flex-1 px-4 py-8 lg:px-40 lg:py-12 flex justify-center">
        <div class="w-full max-w-[1280px] flex flex-col gap-8">
            <div class="flex flex-col gap-2 pb-4 border-b border-border-light dark:border-border-dark mb-4">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900 dark:text-white">{{ __('messages.blog_title') }}</h1>
                <p class="text-lg text-slate-600 dark:text-slate-400">{{ __('messages.blog_desc') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Sidebar (Tags) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 flex flex-col gap-6">
                        <div class="p-6 bg-white dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark shadow-sm">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">label</span>
                                {{ __('messages.filter_by_tag') }}
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $t)
                                    <button wire:click="setTag('{{ $t->name }}')"
                                            class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all {{ $tag === $t->name ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                                        {{ $t->name }}
                                        @if($tag === $t->name) <span class="ml-1 opacity-75">×</span> @endif
                                    </button>
                                @endforeach
                                @if($tags->isEmpty())
                                    <span class="text-sm text-slate-400 italic">{{ __('messages.no_tags') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="lg:col-span-3 flex flex-col gap-6">
                    {{-- Search Input --}}
                    <div class="relative w-full group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400">search</span>
                        </div>
                        <input wire:model.live.debounce.300ms="search"
                               class="block w-full rounded-xl border-none bg-white dark:bg-surface-dark py-3 pl-10 pr-4 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary shadow-sm transition-shadow"
                               placeholder="{{ __('messages.search_placeholder') }}" type="text"/>
                    </div>

                    {{-- Posts List --}}
                    <div class="flex flex-col gap-6">
                        @forelse($posts as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" class="group flex flex-col gap-4 p-6 rounded-2xl bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark hover:border-primary/50 dark:hover:border-primary/50 transition-all shadow-sm hover:shadow-md cursor-pointer">
                            <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wider text-primary">
                                @foreach($post->tags->take(3) as $postTag)
                                <span class="{{ $tag === $postTag->name ? 'underline' : '' }}">{{ $postTag->name }}</span>
                                @if(!$loop->last) <span class="text-slate-300 dark:text-slate-600">•</span> @endif
                                @endforeach
                                <span class="flex-1"></span>
                                <span class="text-slate-500 dark:text-slate-400 font-normal normal-case">{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-2 mt-2">
                                    {{ $post->short_description }}
                                </p>
                            </div>
                            <div class="flex items-center text-sm font-medium text-primary mt-2 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0">
                                {{ __('messages.read_more') }} <span class="material-symbols-outlined text-lg ml-1">arrow_forward</span>
                            </div>
                        </a>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">search_off</span>
                                <p>{{ __('messages.no_posts_found') }}</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</div>
