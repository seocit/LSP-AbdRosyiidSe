<div class="flex min-h-screen gap-6 p-6">
    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 overflow-hidden">
        {{-- Header --}}
        <div class="mb-6" data-aos="fade-down">
            <h1 class="font-display text-3xl font-bold text-ink">Katalog Buku</h1>
            <p class="mt-1 text-sm text-zinc-500">Temukan dan pinjam buku yang ingin kamu baca</p>
        </div>

        {{-- Search & Filter --}}
        <div class="mb-6 flex flex-wrap gap-3" data-aos="fade-up">
            <div class="relative min-w-64 flex-1">
                <svg class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Cari judul, penulis, atau ISBN..."
                    id="search-catalog"
                    class="w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-10 pr-4 text-sm text-zinc-700 shadow-sm focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
            </div>

            <select wire:model.live="categoryFilter" id="filter-category"
                class="rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 shadow-sm focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="yearFilter" id="filter-year"
                class="rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 shadow-sm focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
                <option value="">Semua Tahun</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        {{-- Loading state --}}
        <div wire:loading class="mb-4 text-center text-sm text-zinc-400">
            <span class="animate-pulse">Memuat buku...</span>
        </div>

        {{-- Book Grid --}}
        <div wire:loading.remove>
            @if ($books->isNotEmpty())
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">
                    @foreach ($books as $book)
                        <div class="group h-full [perspective:1000px]" x-data="{ flipped: false }">
                            
                            <div class="relative h-full w-full transition-transform duration-700 [transform-style:preserve-3d]"
                                :class="flipped ? '[transform:rotateY(180deg)]' : ''">
                                
                                {{-- Front Face --}}
                                <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm [backface-visibility:hidden]">
                                    {{-- Cover --}}
                                    <div class="relative aspect-[2/3] overflow-hidden bg-zinc-100">
                                        @if ($book->cover)
                                            <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->title }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        @else
                                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-maroon/10 to-brass/10">
                                                <svg class="size-10 text-maroon/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        {{-- Flip Button --}}
                                        <button @click="flipped = true" type="button"
                                            class="absolute left-2 top-2 z-10 flex size-8 items-center justify-center rounded-full bg-white/90 text-zinc-600 shadow-sm backdrop-blur transition hover:text-maroon hover:shadow" title="Detail Buku">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>

                                        {{-- Stock badge --}}
                                        <div class="absolute right-2 top-2">
                                            @if ($book->stock > 0)
                                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                                    {{ $book->stock }} tersisa
                                                </span>
                                            @else
                                                <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">
                                                    Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex flex-1 flex-col p-3">
                                        <p class="mb-0.5 text-xs text-zinc-400">{{ $book->category?->name }}</p>
                                        <h3 class="line-clamp-2 text-sm font-semibold leading-snug text-ink">{{ $book->title }}</h3>
                                        <p class="mt-0.5 text-xs text-zinc-500">{{ $book->author }}</p>

                                        <div class="mt-auto pt-3">
                                            <button
                                                wire:click="addToCart({{ $book->id }})"
                                                @disabled($book->stock < 1 || isset($cart[$book->id]))
                                                class="w-full rounded-lg px-3 py-2 text-center text-xs font-semibold transition
                                                    {{ $book->stock < 1 ? 'cursor-not-allowed bg-zinc-100 text-zinc-400' :
                                                       (isset($cart[$book->id]) ? 'bg-emerald-100 text-emerald-700 cursor-default' : 'bg-maroon text-paper hover:bg-maroon/90') }}">
                                                {{ isset($cart[$book->id]) ? '✓ Ditambahkan' : ($book->stock < 1 ? 'Stok Habis' : 'Pinjam Buku') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Back Face --}}
                                <div class="absolute inset-0 flex flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm [backface-visibility:hidden] [transform:rotateY(180deg)]">
                                    <div class="mb-2 flex items-center justify-between border-b border-zinc-100 pb-2">
                                        <h4 class="font-semibold text-ink text-sm">Detail Buku</h4>
                                        <button @click="flipped = false" type="button" class="flex size-7 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 transition hover:bg-zinc-200 hover:text-zinc-800" title="Kembali">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex-1 overflow-y-auto pr-1 text-xs text-zinc-600 custom-scrollbar">
                                        <p class="mb-1.5"><span class="font-medium text-zinc-800">Judul:</span> {{ $book->title }}</p>
                                        <p class="mb-1.5"><span class="font-medium text-zinc-800">Penulis:</span> {{ $book->author }}</p>
                                        <p class="mb-1.5"><span class="font-medium text-zinc-800">Penerbit:</span> {{ $book->publisher ?? '-' }}</p>
                                        <p class="mb-1.5"><span class="font-medium text-zinc-800">Tahun:</span> {{ $book->publish_year }}</p>
                                        <p class="mb-1.5"><span class="font-medium text-zinc-800">ISBN:</span> {{ $book->isbn ?? '-' }}</p>
                                        
                                        <div class="mt-2 border-t border-zinc-100 pt-2">
                                            <span class="font-medium text-zinc-800 block mb-1">Sinopsis:</span>
                                            <p class="leading-relaxed">{{ $book->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            @else
                <div class="py-24 text-center">
                    <svg class="mx-auto mb-4 size-12 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-zinc-400">Tidak ada buku yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ===== SIDEBAR KERANJANG ===== --}}
    <aside class="hidden w-72 shrink-0 lg:block">
        <div class="sticky top-24 rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-100 px-5 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-ink">Keranjang Pinjam</h2>
                    <span class="rounded-full bg-maroon px-2 py-0.5 text-xs font-bold text-paper">
                        {{ count($cart) }}/{{ $maxBooks }}
                    </span>
                </div>
            </div>

            <div class="max-h-96 divide-y divide-zinc-100 overflow-y-auto">
                @forelse ($cart as $bookId => $item)
                    <div class="flex items-start gap-3 px-5 py-3">
                        @if ($item['cover'])
                            <img src="{{ Storage::url($item['cover']) }}" alt="{{ $item['title'] }}"
                                class="size-10 shrink-0 rounded object-cover">
                        @else
                            <div class="flex size-10 shrink-0 items-center justify-center rounded bg-zinc-100">
                                <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                </svg>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="line-clamp-2 text-xs font-medium leading-snug text-ink">{{ $item['title'] }}</p>
                            <p class="mt-0.5 text-xs text-zinc-400">{{ $item['author'] }}</p>
                        </div>
                        <button wire:click="removeFromCart({{ $bookId }})"
                            class="ml-1 shrink-0 rounded-full p-1 text-zinc-400 transition hover:bg-red-50 hover:text-red-500">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-sm text-zinc-400">
                        <svg class="mx-auto mb-2 size-8 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p>Belum ada buku dipilih</p>
                    </div>
                @endforelse
            </div>

            <div class="border-t border-zinc-100 p-5">
                <p class="mb-3 text-xs text-zinc-500">
                    Reservasi akan menunggu konfirmasi admin sebelum dapat diambil.
                </p>
                <button wire:click="submitReservation"
                    wire:loading.attr="disabled"
                    wire:target="submitReservation"
                    @disabled(empty($cart))
                    class="w-full rounded-xl py-3 text-sm font-semibold transition
                        {{ empty($cart) ? 'cursor-not-allowed bg-zinc-100 text-zinc-400' : 'bg-maroon text-paper hover:bg-maroon/90' }}">
                    <span wire:loading.remove wire:target="submitReservation">
                        Ajukan Reservasi
                    </span>
                    <span wire:loading wire:target="submitReservation">Mengirim...</span>
                </button>
            </div>
        </div>
    </aside>

    {{-- Notification toast --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        @notify.window="
            message = $event.detail[0].message;
            type = $event.detail[0].type;
            show = true;
            setTimeout(() => show = false, 3500)
        "
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 z-50 rounded-xl px-5 py-3 text-sm font-medium text-white shadow-lg"
        :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error',
            'bg-amber-500': type === 'warning'
        }">
        <span x-text="message"></span>
    </div>
</div>
