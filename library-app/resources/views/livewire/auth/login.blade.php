<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <div class="flex w-full flex-col text-center gap-1">
            <h2 class="font-display text-2xl font-semibold text-ink">{{ __('Masuk ke Akun') }}</h2>
            <p class="text-sm font-serif text-ink/60">{{ __('Masukkan email dan kata sandi Anda di bawah ini') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center font-stamp text-xs text-maroon" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Alamat Email')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="nama@email.com"
                class="font-serif"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Kata Sandi')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Kata Sandi')"
                    viewable
                    class="font-serif"
                />

                @if (Route::has('password.request'))
                    <a class="absolute top-0 right-0 text-xs font-stamp uppercase tracking-wide text-ink/50 hover:text-maroon transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa Sandi?') }}
                    </a>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" class="font-serif text-ink" :label="__('Ingat Saya')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <button type="submit" class="w-full flex items-center justify-center rounded-sm bg-ink text-paper py-3 text-sm font-stamp uppercase tracking-wide hover:bg-maroon transition-colors cursor-pointer" data-test="login-button">
                    {{ __('Masuk') }}
                </button>
            </div>
        </form>

        <div class="space-x-1 text-center text-sm font-serif text-ink/60">
            <span>{{ __('Belum punya akun?') }}</span>
            <a href="{{ route('register') }}" class="font-stamp text-xs uppercase tracking-wide text-maroon hover:underline" wire:navigate>{{ __('Daftar') }}</a>
        </div>
    </div>
</x-layouts::auth>
