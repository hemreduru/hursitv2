<div class="max-w-4xl mx-auto space-y-8">
    <section>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">{{ __('messages.admin_tags_management') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('messages.admin_organize_content') }}</p>
            </div>
            <a href="{{ route('admin.tags.create') }}" class="flex items-center justify-center gap-2 bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium shadow-lg shadow-primary/20 transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-lg">add</span>
                {{ __('messages.admin_new_tag') }}
            </a>
        </div>
        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl overflow-hidden shadow-sm mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-border-light dark:border-border-dark">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_name') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_slug') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_lang') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white text-right">{{ __('messages.admin_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        @forelse($tags as $tag)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium">{{ $tag->name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $tag->slug }}</td>
                            <td class="px-6 py-4 text-slate-500 uppercase">{{ $tag->locale }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="text-slate-400 hover:text-primary transition-colors mr-2 inline-block"><span class="material-symbols-outlined text-lg">edit</span></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-slate-500">{{ __('messages.admin_no_tags') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="px-6 py-4 border-t border-border-light dark:border-border-dark">
                {{ $tags->links() }}
            </div>
        </div>
    </section>
</div>
