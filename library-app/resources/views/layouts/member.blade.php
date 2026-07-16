<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-paper font-sans antialiased">

        {{-- NAVBAR --}}
        <header class="sticky top-0 z-50 bg-maroon shadow-md">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 py-3">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
                    <div class="flex size-9 items-center justify-center rounded-full bg-brass/20">
                        <svg class="size-5 text-brass" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-display text-lg font-semibold text-paper">
                        {{ config('app.name', 'Perpustakaan') }}
                    </span>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden items-center gap-1 md:flex">
                    <a href="{{ route('home') }}"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-paper/80 transition hover:bg-white/10 hover:text-paper {{ request()->routeIs('home') ? 'bg-white/10 text-paper' : '' }}"
                        wire:navigate>Beranda</a>

                    @auth
                        @role('anggota')
                            <a href="{{ route('member.peminjaman') }}"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-paper/80 transition hover:bg-white/10 hover:text-paper {{ request()->routeIs('member.peminjaman') ? 'bg-white/10 text-paper' : '' }}"
                                wire:navigate>Katalog Buku</a>
                            <a href="{{ route('member.list-peminjaman') }}"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-paper/80 transition hover:bg-white/10 hover:text-paper {{ request()->routeIs('member.list-peminjaman') ? 'bg-white/10 text-paper' : '' }}"
                                wire:navigate>Peminjaman Saya</a>
                        @endrole
                    @endauth

                    <a href="{{ route('announcements.index') }}"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-paper/80 transition hover:bg-white/10 hover:text-paper {{ request()->routeIs('announcements.index') ? 'bg-white/10 text-paper' : '' }}"
                        wire:navigate>Pengumuman</a>
                </div>

                {{-- Auth Section --}}
                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-paper/80 transition hover:text-paper"
                            wire:navigate>Masuk</a>
                        <a href="{{ route('register') }}"
                            class="rounded-lg bg-brass px-4 py-2 text-sm font-medium text-ink transition hover:bg-brass/90"
                            wire:navigate>Daftar</a>
                    @endguest

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-paper/90 transition hover:bg-white/10">
                                <div class="flex size-8 items-center justify-center rounded-full bg-brass font-semibold text-ink text-xs">
                                    {{ auth()->user()->initials() }}
                                </div>
                                <span class="hidden font-medium md:block">{{ auth()->user()->name }}</span>
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-cloak @click.outside="open = false"
                                class="absolute right-0 mt-2 w-48 rounded-xl border border-zinc-200 bg-white py-1 shadow-lg">
                                @role('anggota')
                                    <a href="{{ route('member.profile') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-50"
                                        wire:navigate>
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                @endrole
                                @role('admin')
                                    <a href="{{ route('dashboard') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-50"
                                        wire:navigate>
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard Admin
                                    </a>
                                @endrole
                                <hr class="my-1 border-zinc-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    {{-- Mobile menu toggle --}}
                    <button class="rounded-lg p-2 text-paper/80 hover:bg-white/10 md:hidden" x-data
                        @click="$dispatch('toggle-mobile-menu')">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </nav>

            {{-- Mobile Menu --}}
            <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open">
                <div x-show="open" x-cloak class="border-t border-white/10 bg-maroon px-4 py-4 md:hidden">
                    <div class="flex flex-col gap-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-paper/80 hover:bg-white/10" wire:navigate>
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        @auth
                            @role('anggota')
                                <a href="{{ route('member.peminjaman') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-paper/80 hover:bg-white/10" wire:navigate>
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                                    Katalog Buku
                                </a>
                                <a href="{{ route('member.list-peminjaman') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-paper/80 hover:bg-white/10" wire:navigate>
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                                    Peminjaman Saya
                                </a>
                                <a href="{{ route('member.profile') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-paper/80 hover:bg-white/10" wire:navigate>
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                            @endrole
                        @endauth
                        <a href="{{ route('announcements.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-paper/80 hover:bg-white/10" wire:navigate>
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14"/></svg>
                            Pengumuman
                        </a>
                        @auth
                            <div class="mt-2 border-t border-white/10 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-red-300 hover:bg-white/10">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="pb-10">
            {{ $slot }}
        </main>

        {{-- FOOTER --}}
        <footer class="mt-10 sm:mt-16 bg-ink py-8 sm:py-10 text-paper/60">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="flex flex-col items-center gap-2 text-center">
                    <span class="font-display text-base sm:text-lg font-semibold text-paper">{{ config('app.name', 'Perpustakaan') }}</span>
                    <p class="text-xs sm:text-sm">Membangun Budaya Baca, Memberdayakan Masyarakat.</p>
                    <p class="mt-1 text-xs">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts

        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init({ duration: 700, once: true, easing: 'ease-out-cubic' });
        </script>
    </body>
</html>
