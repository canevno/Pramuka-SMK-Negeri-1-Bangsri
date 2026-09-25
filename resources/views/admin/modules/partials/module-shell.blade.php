<section class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modul Admin</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
        </div>

        @if(!empty($publicRoute) && !empty($publicLabel))
            <a href="{{ $publicRoute }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                {{ $publicLabel }}
            </a>
        @endif
    </div>

    @if(!empty($stats))
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40">
                    @if(!empty($stat['image']))
                        <img src="{{ asset($stat['image']) }}" alt="{{ $stat['label'] }}" class="mb-3 h-24 w-full rounded-xl object-cover shadow-sm">
                    @endif
                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                    @if(!empty($stat['value']))
                        <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $stat['value'] }}</p>
                    @endif
                    <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">{{ $stat['caption'] ?? 'Terbaru' }}</p>
                </div>
            @endforeach
        </div>
    @endif

    @if(!empty($table))
        <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        <tr>
                            @foreach($table['headers'] as $header)
                                <th class="px-4 py-3">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                        @foreach($table['rows'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                    <td class="px-4 py-3">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if(!empty($formFields))
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-800/30">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Formulir {{ $title }}</h3>
                <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Siap diproses</span>
            </div>

            <form class="grid gap-4 md:grid-cols-2">
                @foreach($formFields as $field)
                    <label class="block {{ $field['full'] ?? false ? 'md:col-span-2' : '' }}">
                        <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">{{ $field['label'] }}</span>
                        @if(($field['type'] ?? 'text') === 'textarea')
                            <textarea rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="{{ $field['placeholder'] ?? '' }}"></textarea>
                        @elseif(($field['type'] ?? 'text') === 'select')
                            <select class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                @foreach($field['options'] ?? [] as $option)
                                    <option>{{ $option }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{ $field['type'] ?? 'text' }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="{{ $field['placeholder'] ?? '' }}" />
                        @endif
                    </label>
                @endforeach

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500">
                        Simpan {{ $title }}
                    </button>
                </div>
            </form>
        </div>
    @endif
</section>
