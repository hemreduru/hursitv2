<div class="min-h-screen flex flex-col bg-background-light dark:bg-background-dark font-display">
    @include('partials.navbar')

    <main class="flex-1 flex flex-col items-center py-10 px-4 md:px-10">
        <div class="max-w-[1200px] w-full flex flex-col gap-8">
            <div class="flex flex-col gap-4 py-4">
                <h1 class="text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] text-gray-900 dark:text-white">
                    {{ __('messages.projects_title') }}
                </h1>
                <p class="text-gray-600 dark:text-[#92a4c9] text-lg font-normal leading-relaxed max-w-2xl">
                    {{ __('messages.projects_desc') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="group flex flex-col bg-white dark:bg-card-dark rounded-xl border border-gray-200 dark:border-card-border overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 transition-all duration-300 hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-1">
                    <div class="h-48 w-full bg-slate-800 relative overflow-hidden">
                        <!-- Placeholder Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary to-purple-500 opacity-20"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>

                        @if($project->is_featured)
                        <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                            <span class="inline-flex items-center rounded-md bg-purple-400/10 px-2 py-1 text-xs font-medium text-purple-400 ring-1 ring-inset ring-purple-400/30 backdrop-blur-sm">{{ __('messages.featured_label') }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-1 gap-4">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">{{ $project->title }}</h3>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed line-clamp-3">
                            {{ $project->short_description }}
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
                             <div class="flex flex-wrap gap-2">
                                @if($project->tech_stack)
                                    @foreach($project->tech_stack as $tech)
                                        <span class="px-2 py-1 rounded-md bg-gray-100 dark:bg-[#232f48] text-xs font-medium text-gray-600 dark:text-gray-300">{{ $tech }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                    <div class="col-span-3 text-center text-slate-500 dark:text-slate-400 py-10">
                        {{ __('messages.no_projects_found') }}
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    @include('partials.footer')
</div>
