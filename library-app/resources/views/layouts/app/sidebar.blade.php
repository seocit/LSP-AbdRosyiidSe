<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @stack('styles')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user-plus" :href="route('admin.verifikasi-anggota')" :current="request()->routeIs('admin.verifikasi-anggota')" wire:navigate>
                        {{ __('Verifikasi Anggota') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.verifikasi-reservasi')" :current="request()->routeIs('admin.verifikasi-reservasi')" wire:navigate>
                        {{ __('Verifikasi Reservasi') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="banknotes" :href="route('admin.verifikasi-pembayaran')" :current="request()->routeIs('admin.verifikasi-pembayaran')" wire:navigate>
                        {{ __('Verifikasi Pembayaran') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrow-uturn-left" :href="route('admin.verifikasi-pengembalian')" :current="request()->routeIs('admin.verifikasi-pengembalian')" wire:navigate>
                        {{ __('Pengembalian Buku') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Manajemen')" class="grid mt-4">
                    <flux:sidebar.item icon="users" :href="route('admin.kelola-anggota')" :current="request()->routeIs('admin.kelola-anggota')" wire:navigate>
                        {{ __('Kelola Anggota') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="book-open" :href="route('admin.buku')" :current="request()->routeIs('admin.buku')" wire:navigate>
                        {{ __('Kelola Buku') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="megaphone" :href="route('admin.pengumuman')" :current="request()->routeIs('admin.pengumuman')" wire:navigate>
                        {{ __('Pengumuman') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cog-8-tooth" :href="route('admin.konfigurasi')" :current="request()->routeIs('admin.konfigurasi')" wire:navigate>
                        {{ __('Konfigurasi Sistem') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <!-- <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav> -->

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @stack('scripts')
        @fluxScripts
    </body>
</html>
