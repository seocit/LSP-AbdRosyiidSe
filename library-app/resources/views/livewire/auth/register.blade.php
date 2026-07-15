<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <div class="flex w-full flex-col text-center gap-1">
            <h2 class="font-display text-2xl font-semibold text-ink">{{ __('Daftar Anggota Baru') }}</h2>
            <p class="text-sm font-serif text-ink/60">{{ __('Masukkan informasi pendaftaran Anda di bawah ini') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center font-stamp text-xs text-maroon" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Nama Lengkap')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Nama lengkap Anda')"
                class="font-serif"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Alamat Email')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="nama@email.com"
                class="font-serif"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Kata Sandi')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Kata Sandi')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
                class="font-serif"
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Konfirmasi Kata Sandi')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Konfirmasi Kata Sandi')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
                class="font-serif"
            />

            <div class="flex items-center justify-end">
                <button type="submit" class="w-full flex items-center justify-center rounded-sm bg-ink text-paper py-3 text-sm font-stamp uppercase tracking-wide hover:bg-maroon transition-colors cursor-pointer" data-test="register-user-button">
                    {{ __('Buat Akun') }}
                </button>
            </div>
        </form>

        <div class="space-x-1 text-center text-sm font-serif text-ink/60">
            <span>{{ __('Sudah punya akun?') }}</span>
            <a href="{{ route('login') }}" class="font-stamp text-xs uppercase tracking-wide text-maroon hover:underline" wire:navigate>{{ __('Masuk') }}</a>
        </div>
    </div>
</x-layouts::auth>
