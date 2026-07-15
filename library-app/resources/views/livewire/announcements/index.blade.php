<div class="mx-auto max-w-7xl px-6 py-10">
    <div class="mb-8" data-aos="fade-down">
        <span class="mb-2 inline-block text-xs font-semibold uppercase tracking-widest text-brass">Info</span>
        <h1 class="font-display text-3xl font-bold text-ink md:text-4xl">Pengumuman</h1>
        <p class="mt-2 text-zinc-500">Informasi dan pembaruan terbaru dari perpustakaan kami</p>
    </div>

    {{-- Search --}}
    <div class="mb-10 max-w-md" data-aos="fade-up">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" wire:model.live.debounce.500ms="search"
                placeholder="Cari pengumuman..."
                id="search-announcements"
                class="w-full rounded-xl border border-zinc-200 bg-white py-3 pl-10 pr-4 text-sm text-zinc-700 shadow-sm transition focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
        </div>
    </div>

    {{-- Loading state --}}
    <div wire:loading class="mb-8 text-center text-sm text-zinc-400">
        <span class="animate-pulse">Mencari...</span>
    </div>

    {{-- Grid --}}
    <div wire:loading.remove>
        @if ($announcements->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($announcements as $i => $ann)
                    <article class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                        data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                        @if ($ann->image)
                            <img src="{{ Storage::url($ann->image) }}" alt="{{ $ann->title }}"
                                class="h-48 w-full object-cover">
                        @else
                            <div class="flex h-48 items-center justify-center bg-gradient-to-br from-maroon/5 to-brass/10">
                                <svg class="size-12 text-brass/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="mb-3 flex items-center justify-between">
                                <span class="rounded-full bg-brass/10 px-2.5 py-0.5 text-xs font-semibold text-brass">Pengumuman</span>
                                <span class="text-xs text-zinc-400">{{ $ann->created_at->format('d M Y') }}</span>
                            </div>
                            <h2 class="mb-3 font-display text-lg font-bold leading-snug text-ink">{{ $ann->title }}</h2>
                            <div class="prose prose-sm prose-zinc line-clamp-4 text-zinc-500">
                                {!! strip_tags($ann->content) !!}
                            </div>
                            
                            {{-- Modal trigger (if we want to show full details later, for now we just show snippet) --}}
                            <div class="mt-4 pt-4 border-t border-zinc-100" x-data="{ open: false }">
                                <button @click="open = true" class="text-sm font-semibold text-maroon hover:underline">
                                    Baca Selengkapnya
                                </button>
                                
                                {{-- Simple Alpine Modal for Announcement Detail --}}
                                <template x-teleport="body">
                                    <div x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-ink/50 backdrop-blur-sm">
                                    <div @click.outside="open = false" 
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-3xl shadow-2xl relative">
                                        
                                        <button @click="open = false" class="absolute top-4 right-4 p-2 rounded-full bg-zinc-100 text-zinc-500 hover:bg-zinc-200">
                                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                        
                                        @if ($ann->image)
                                            <img src="{{ Storage::url($ann->image) }}" alt="{{ $ann->title }}" class="w-full h-64 object-cover">
                                        @endif
                                        
                                        <div class="p-8">
                                            <div class="mb-4 flex items-center gap-3">
                                                <span class="rounded-full bg-brass/10 px-3 py-1 text-xs font-semibold text-brass">Pengumuman</span>
                                                <span class="text-sm text-zinc-500">{{ $ann->created_at->translatedFormat('l, d F Y') }}</span>
                                            </div>
                                            <h2 class="mb-6 font-display text-2xl font-bold text-ink">{{ $ann->title }}</h2>
                                            <div class="prose prose-zinc max-w-none">
                                                {!! $ann->content !!}
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $announcements->links() }}
            </div>
        @else
            <div class="py-24 text-center">
                <svg class="mx-auto mb-4 size-12 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                </svg>
                <p class="text-zinc-400">Tidak ada pengumuman yang ditemukan.</p>
            </div>
        @endif
    </div>
</div>
