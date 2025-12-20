<div class="max-w-6xl mx-auto space-y-8">
    <section>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">{{ __('messages.admin_blog_management') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('messages.admin_create_manage_blog') }}</p>
            </div>
            <!-- TODO: Add Create Route -->
            <button class="flex items-center justify-center gap-2 bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium shadow-lg shadow-primary/20 transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-lg">add</span>
                {{ __('messages.admin_new_post') }}
            </button>
        </div>
        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl overflow-hidden shadow-sm mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-border-light dark:border-border-dark">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_title') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_status') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_date') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_lang') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white text-right">{{ __('messages.admin_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        @forelse($posts as $post)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium">{{ $post->title }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $post->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}</td>
                            <td class="px-6 py-4 text-slate-500 uppercase">{{ $post->locale }}</td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-primary transition-colors mr-2"><span class="material-symbols-outlined text-lg">edit</span></button>
                                <button class="text-slate-400 hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-slate-500">{{ __('messages.admin_no_posts') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-border-light dark:border-border-dark">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
</div>
