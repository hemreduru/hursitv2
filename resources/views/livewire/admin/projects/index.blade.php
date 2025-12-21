<div class="max-w-6xl mx-auto space-y-8">
    <section>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">{{ __('messages.admin_project_management') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('messages.admin_showcase_work') }}</p>
            </div>
            <a href="{{ route('admin.projects.create') }}" class="flex items-center justify-center gap-2 bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium shadow-lg shadow-primary/20 transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-lg">add</span>
                {{ __('messages.admin_new_project') }}
            </a>
        </div>
        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl p-4 mb-6 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                     <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('messages.admin_search_placeholder') }}" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
                <div>
                    <select wire:model.live="featured" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        <option value="">{{ __('messages.admin_all_projects') }}</option>
                        <option value="1">{{ __('messages.admin_featured_only') }}</option>
                        <option value="0">{{ __('messages.admin_standard_only') }}</option>
                    </select>
                </div>
                <div>
                    <select wire:model.live="locale" class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                         <option value="">{{ __('messages.admin_all_languages') }}</option>
                        <option value="en">English</option>
                        <option value="tr">Türkçe</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl overflow-hidden shadow-sm mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-border-light dark:border-border-dark">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_title') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_featured') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_tech_stack') }}</th>
                             <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white">{{ __('messages.admin_lang') }}</th>
                            <th class="px-6 py-3 font-semibold text-slate-900 dark:text-white text-right">{{ __('messages.admin_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        @forelse($projects as $project)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium">{{ $project->title }}</td>
                            <td class="px-6 py-4">
                                @if($project->is_featured)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">{{ __('messages.admin_featured') }}</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                @if($project->tech_stack)
                                    {{ implode(', ', array_slice($project->tech_stack, 0, 3)) }}{{ count($project->tech_stack) > 3 ? '...' : '' }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 uppercase">{{ $project->locale }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-slate-400 hover:text-primary transition-colors mr-2 inline-block"><span class="material-symbols-outlined text-lg">edit</span></a>
                                <button
                                    onclick="confirmAction(this, 'delete', [{{ $project->id }}])"
                                    data-title="{{ __('messages.are_you_sure') }}"
                                    data-text="{{ __('messages.delete_warning') }}"
                                    data-confirm-text="{{ __('messages.yes_delete') }}"
                                    data-cancel-text="{{ __('messages.cancel') }}"
                                    class="text-slate-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-slate-500">{{ __('messages.admin_no_projects') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="px-6 py-4 border-t border-border-light dark:border-border-dark">
                {{ $projects->links() }}
            </div>
        </div>
    </section>
</div>
