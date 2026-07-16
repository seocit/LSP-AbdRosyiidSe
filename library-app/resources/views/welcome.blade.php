{{-- Landing Page - Perpustakaan --}}
<div>
    {{-- ===== HERO SECTION ===== --}}
    <section class="relative overflow-hidden py-16 md:py-24 lg:py-24">

        {{-- Video Background --}}
        <div class="absolute inset-0 z-0">
            <video autoplay loop muted playsinline class="h-full w-full object-cover">
                {{-- Gunakan URL video library atau buku (Contoh dari Mixkit) --}}
                <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
            </video>
            {{-- Dark Overlay for readability --}}
            <div class="absolute inset-0 bg-black/60"></div>
            {{-- Gradient overlay for styling matching theme --}}
            <div class="absolute inset-0 bg-gradient-to-br from-maroon/50 to-[#4a1a1a]/10"></div>
        </div>

        {{-- Decorative background --}}
        <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden mix-blend-overlay opacity-30">
            <div class="absolute -right-32 -top-32 size-96 rounded-full bg-brass blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 size-80 rounded-full bg-brass blur-3xl"></div>
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-20">
                <svg class="w-[600px]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 text-center">
            <div data-aos="fade-down" data-aos-delay="100">
                <span class="mb-4 inline-block rounded-full border border-brass/30 bg-brass/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-brass">
                    Perpustakaan Digital
                </span>
            </div>

            <h1 class="font-display text-3xl font-bold text-paper sm:text-4xl md:text-5xl lg:text-7xl" data-aos="fade-up" data-aos-delay="200">
                Temukan Buku<br>
                <span class="text-brass">Impianmu</span> di Sini
            </h1>
            <p class="mx-auto mt-4 max-w-2xl text-sm sm:text-base lg:text-lg text-paper/70 px-2" data-aos="fade-up" data-aos-delay="300">
                Jelajahi ribuan koleksi buku kami. Daftar sebagai anggota dan mulai perjalanan literasimu hari ini secara gratis.
            </p>

            <div class="mt-8 flex flex-col items-stretch justify-center gap-3 px-4 sm:flex-row sm:items-center sm:px-0" data-aos="fade-up" data-aos-delay="400">
                @guest
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-brass px-6 py-3.5 text-sm sm:text-base font-semibold text-ink shadow-lg transition hover:bg-brass/90 hover:shadow-brass/30"
                        wire:navigate>
                        Daftar Sekarang
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-paper/30 px-6 py-3.5 text-sm sm:text-base font-medium text-paper transition hover:bg-white/10"
                        wire:navigate>
                        Sudah Punya Akun? Masuk
                    </a>
                @endguest

                @auth
                    @role('anggota')
                        <a href="{{ route('member.peminjaman') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-brass px-8 py-3.5 text-base font-semibold text-ink shadow-lg transition hover:bg-brass/90"
                            wire:navigate>
                            Pinjam Buku
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    @endrole
                @endauth
            </div>

            {{-- Stats --}}
            <div class="mt-10 sm:mt-16 grid grid-cols-3 gap-3 sm:gap-6 border-t border-white/10 pt-8 sm:pt-12" data-aos="fade-up" data-aos-delay="500">
                <div class="text-center">
                    <div class="font-display text-2xl sm:text-3xl font-bold text-brass">1000+</div>
                    <div class="mt-1 text-xs sm:text-sm text-paper/60">Koleksi Buku</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-2xl sm:text-3xl font-bold text-brass">50+</div>
                    <div class="mt-1 text-xs sm:text-sm text-paper/60">Kategori</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-2xl sm:text-3xl font-bold text-brass">500+</div>
                    <div class="mt-1 text-xs sm:text-sm text-paper/60">Anggota Aktif</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== KATALOG BUKU ===== --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="mb-12 text-center" data-aos="fade-up">
                <span class="mb-2 inline-block text-xs font-semibold uppercase tracking-widest text-brass">Koleksi</span>
                <h2 class="font-display text-3xl font-bold text-ink md:text-4xl">Buku Tersedia</h2>
                <p class="mt-3 text-zinc-500">Temukan buku yang ingin kamu baca dari koleksi kami</p>
            </div>

            {{-- Search & Filter --}}
            <div class="mb-8 flex flex-col gap-3 sm:flex-row" data-aos="fade-up" data-aos-delay="100">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari judul atau penulis..."
                        id="search-books-home"
                        class="w-full rounded-xl border border-zinc-200 bg-white py-3 pl-10 pr-4 text-sm text-zinc-700 shadow-sm transition focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
                </div>
                <select wire:model.live="categoryFilter" id="category-filter-home"
                    class="w-full sm:w-auto rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-700 shadow-sm focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Book Grid --}}
            @if ($books->isNotEmpty())
                <div class="grid grid-cols-2 gap-3 sm:gap-5 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($books as $i => $book)
                        <div class="group h-full [perspective:1000px]" x-data="{ flipped: false }"
                            data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 75 }}">
                            
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
                                                <svg class="size-12 text-maroon/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                                {{ $book->stock }} tersisa
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex flex-1 flex-col p-3 sm:p-4">
                                        <p class="mb-1 text-xs text-zinc-400">{{ $book->category?->name }}</p>
                                        <h3 class="line-clamp-2 text-sm font-semibold leading-snug text-ink">{{ $book->title }}</h3>
                                        <p class="mt-1 text-xs text-zinc-500">{{ $book->author }}</p>

                                        <div class="mt-auto pt-3">
                                            @guest
                                                <a href="{{ route('login') }}"
                                                    class="block rounded-lg bg-maroon px-3 py-2 text-center text-xs font-semibold text-paper transition hover:bg-maroon/90"
                                                    wire:navigate>
                                                    Login untuk Pinjam
                                                </a>
                                            @endguest
                                            @auth
                                                @role('anggota')
                                                    <a href="{{ route('member.peminjaman') }}"
                                                        class="block rounded-lg bg-maroon px-3 py-2 text-center text-xs font-semibold text-paper transition hover:bg-maroon/90"
                                                        wire:navigate>
                                                        Pinjam Buku
                                                    </a>
                                                @endrole
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Back Face --}}
                                <div class="absolute inset-0 flex flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm [backface-visibility:hidden] [transform:rotateY(180deg)]">
                                    <div class="mb-3 flex items-center justify-between border-b border-zinc-100 pb-2">
                                        <h4 class="font-semibold text-ink text-sm">Detail Buku</h4>
                                        <button @click="flipped = false" type="button" class="flex size-7 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 transition hover:bg-zinc-200 hover:text-zinc-800" title="Kembali">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex-1 overflow-y-auto pr-1 text-xs text-zinc-600 custom-scrollbar">
                                        <p class="mb-2"><span class="font-medium text-zinc-800">Judul:</span> {{ $book->title }}</p>
                                        <p class="mb-2"><span class="font-medium text-zinc-800">Penulis:</span> {{ $book->author }}</p>
                                        <p class="mb-2"><span class="font-medium text-zinc-800">Penerbit:</span> {{ $book->publisher ?? '-' }}</p>
                                        <p class="mb-2"><span class="font-medium text-zinc-800">Tahun:</span> {{ $book->publish_year }}</p>
                                        <p class="mb-2"><span class="font-medium text-zinc-800">ISBN:</span> {{ $book->isbn ?? '-' }}</p>
                                        
                                        <div class="mt-3 border-t border-zinc-100 pt-3">
                                            <span class="font-medium text-zinc-800 block mb-1">Sinopsis:</span>
                                            <p class="leading-relaxed">{{ $book->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 text-center" data-aos="fade-up">
                    <a href="{{ auth()->check() && auth()->user()->hasRole('anggota') ? route('member.peminjaman') : route('login') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-maroon px-6 py-3 text-sm font-semibold text-maroon transition hover:bg-maroon hover:text-paper"
                        wire:navigate>
                        Lihat Semua Buku
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="py-20 text-center text-zinc-400">
                    <svg class="mx-auto mb-4 size-12 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Tidak ada buku yang sesuai pencarian.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ===== PENGUMUMAN ===== --}}
    @if ($announcements->isNotEmpty())
        <section class="bg-zinc-50 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="mb-8 sm:mb-12 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between" data-aos="fade-up">
                    <div>
                        <span class="mb-2 inline-block text-xs font-semibold uppercase tracking-widest text-brass">Info</span>
                        <h2 class="font-display text-3xl font-bold text-ink md:text-4xl">Pengumuman</h2>
                        <p class="mt-2 text-zinc-500">Informasi terbaru dari perpustakaan</p>
                    </div>
                    <a href="{{ route('announcements.index') }}"
                        class="flex items-center gap-1 text-sm font-semibold text-maroon hover:underline"
                        wire:navigate>
                        Lihat Semua
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($announcements as $i => $ann)
                        <article class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                            data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            @if ($ann->image)
                                <img src="{{ Storage::url($ann->image) }}" alt="{{ $ann->title }}"
                                    class="h-44 w-full object-cover">
                            @else
                                <div class="flex h-44 items-center justify-center bg-gradient-to-br from-maroon/5 to-brass/10">
                                    <svg class="size-12 text-brass/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5">
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="rounded-full bg-brass/10 px-2.5 py-0.5 text-xs font-semibold text-brass">Pengumuman</span>
                                    <span class="text-xs text-zinc-400">{{ $ann->created_at->format('d M Y') }}</span>
                                </div>
                                <h3 class="mb-2 line-clamp-2 font-semibold leading-snug text-ink">{{ $ann->title }}</h3>
                                <div class="line-clamp-3 text-sm leading-relaxed text-zinc-500">
                                    {!! strip_tags($ann->content) !!}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>


            </div>
        </section>
    @endif

    {{-- ===== CTA SECTION ===== --}}
    <section class="py-20">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 text-center" data-aos="fade-up">
            <div class="rounded-3xl bg-gradient-to-br from-maroon to-[#4a1a1a] px-5 py-10 sm:px-8 sm:py-16 shadow-2xl">
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-paper md:text-4xl">
                    Siap Mulai Membaca?
                </h2>
                <p class="mt-4 text-paper/70">
                    Bergabunglah dengan ribuan pembaca aktif dan nikmati akses ke koleksi buku pilihan kami.
                </p>
                @guest
                    <div class="mt-6 sm:mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-brass px-6 py-3.5 text-sm sm:text-base font-semibold text-ink transition hover:bg-brass/90"
                            wire:navigate>
                            Daftar Gratis
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-paper/30 px-6 py-3.5 text-sm sm:text-base font-medium text-paper transition hover:bg-white/10"
                            wire:navigate>
                            Masuk
                        </a>
                    </div>
                @endguest
                @auth
                    @role('anggota')
                        <a href="{{ route('member.peminjaman') }}"
                            class="mt-8 inline-flex items-center gap-2 rounded-xl bg-brass px-8 py-3.5 font-semibold text-ink transition hover:bg-brass/90"
                            wire:navigate>
                            Jelajahi Buku Sekarang →
                        </a>
                    @endrole
                @endauth
            </div>
        </div>
    </section>
</div>