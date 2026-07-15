<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>
            .bg-grain::before {
                content: "";
                position: absolute; inset: 0;
                background-image: radial-gradient(circle at 1px 1px, rgba(27,27,24,0.06) 1px, transparent 0);
                background-size: 20px 20px;
                pointer-events: none;
            }
        </style>
    </head>
    <body class="min-h-screen bg-paper text-ink font-serif antialiased bg-grain relative">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                {{-- Logo and Header --}}
                <div class="flex flex-col items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
                        <span class="relative flex items-center justify-center w-11 h-11 rounded-full border-2 border-ink bg-paper">
                            <svg viewBox="0 0 24 24" class="w-5 h-5 text-ink" fill="none" stroke="currentColor" stroke-width="1.4">
                                <path d="M4 5.5C4 4.67 4.67 4 5.5 4H11V19H5.5C4.67 19 4 18.33 4 17.5V5.5Z"/>
                                <path d="M20 5.5C20 4.67 19.33 4 18.5 4H13V19H18.5C19.33 19 20 18.33 20 17.5V5.5Z"/>
                                <path d="M11 4C11 4 12 5 12 6.5C12 5 13 4 13 4"/>
                            </svg>
                        </span>
                        <span class="font-display text-2xl font-semibold tracking-tight text-ink">
                            {{ config('app.name', 'Perpustakaan') }}
                        </span>
                    </a>
                </div>

                {{-- Catalog Card Box --}}
                <div class="bg-paper border border-ink/15 rounded-sm p-6 sm:p-8 shadow-xl relative overflow-hidden">
                    {{-- Catalog Card header/stamp --}}
                    <div class="flex items-center justify-between mb-6 border-b border-ink/10 pb-4">
                        <span class="font-stamp text-[11px] tracking-[0.25em] uppercase text-ink/40">Katalog Digital</span>
                        <span class="font-stamp text-[11px] tracking-[0.25em] uppercase text-ink/40">No. {{ request()->routeIs('register') ? '01-REG' : '02-LOG' }}</span>
                    </div>

                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
