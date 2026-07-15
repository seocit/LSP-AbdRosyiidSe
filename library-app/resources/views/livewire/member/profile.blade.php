<div class="mx-auto max-w-4xl px-6 py-10">

    {{-- ===== PROFILE HEADER ===== --}}
    <div class="mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-maroon to-[#4a1a1a] p-8 text-paper shadow-lg">
        <div class="flex flex-col items-center gap-6 sm:flex-row">
            {{-- Avatar --}}
            <div class="relative">
                <div class="size-24 overflow-hidden rounded-full border-4 border-brass/40 shadow-lg">
                    @if ($user->avatar ?? null)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-brass/20 font-display text-3xl font-bold text-brass">
                            {{ $user->initials() }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="text-center sm:text-left">
                <h1 class="font-display text-2xl font-bold">{{ $user->name }}</h1>
                <p class="mt-0.5 text-paper/60">{{ $user->email }}</p>
                @foreach ($user->roles as $role)
                    <span class="mt-2 inline-block rounded-full border border-brass/30 bg-brass/10 px-3 py-0.5 text-xs font-semibold text-brass">
                        {{ ucfirst($role->name) }}
                    </span>
                @endforeach
            </div>

            {{-- Stats --}}
            <div class="ml-auto grid grid-cols-2 gap-4 text-center">
                <div class="rounded-2xl bg-white/10 px-6 py-4">
                    <div class="font-display text-2xl font-bold">{{ $totalBorrowed }}</div>
                    <div class="mt-0.5 text-xs text-paper/60">Total Dipinjam</div>
                </div>
                <div class="rounded-2xl bg-white/10 px-6 py-4">
                    <div class="font-display text-2xl font-bold">{{ $currentlyBorrowed }}</div>
                    <div class="mt-0.5 text-xs text-paper/60">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- ===== LEFT: EDIT PROFILE CARD ===== --}}
        <div class="space-y-4 lg:col-span-1">
            {{-- Profile Info Card --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold text-ink">Informasi Akun</h2>
                    <button wire:click="$toggle('isEditMode')"
                        class="text-xs font-medium text-maroon hover:underline">
                        {{ $isEditMode ? 'Batal' : 'Edit' }}
                    </button>
                </div>

                @if (!$isEditMode)
                    {{-- View Mode --}}
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-xs text-zinc-400">Nama Lengkap</p>
                            <p class="font-medium text-ink">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-zinc-400">Email</p>
                            <p class="font-medium text-ink">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-zinc-400">No. WhatsApp</p>
                            <p class="font-medium text-ink">{{ $user->phone_number ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-zinc-400">Status Akun</p>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                @else
                    {{-- Edit Mode --}}
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">Foto Profil</label>
                            <input type="file" wire:model="avatar" accept="image/*" id="avatar-upload"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-xs text-zinc-700 file:mr-2 file:rounded file:border-0 file:bg-maroon file:px-2 file:py-1 file:text-xs file:text-paper">
                            @error('avatar') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">Nama Lengkap</label>
                            <input type="text" wire:model="name" id="edit-name"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-maroon focus:outline-none">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">Email</label>
                            <input type="email" wire:model="email" id="edit-email"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-maroon focus:outline-none">
                            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">No. WhatsApp</label>
                            <input type="text" wire:model="phoneNumber" id="edit-phone"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-maroon focus:outline-none">
                        </div>
                        <button wire:click="saveProfile"
                            wire:loading.attr="disabled"
                            class="w-full rounded-xl bg-maroon py-2.5 text-sm font-semibold text-paper transition hover:bg-maroon/90">
                            Simpan Perubahan
                        </button>
                    </div>
                @endif
            </div>

            {{-- Password Card --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-semibold text-ink">Keamanan</h2>
                    <button wire:click="$toggle('isPasswordMode')"
                        class="text-xs font-medium text-maroon hover:underline">
                        {{ $isPasswordMode ? 'Batal' : 'Ganti Password' }}
                    </button>
                </div>

                @if ($isPasswordMode)
                    <div class="space-y-3">
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">Password Saat Ini</label>
                            <input type="password" wire:model="currentPassword" id="current-password"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-maroon focus:outline-none">
                            @error('currentPassword') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">Password Baru</label>
                            <input type="password" wire:model="newPassword" id="new-password"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-maroon focus:outline-none">
                            @error('newPassword') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-600">Konfirmasi Password</label>
                            <input type="password" wire:model="newPasswordConfirmation" id="confirm-password"
                                class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-maroon focus:outline-none">
                        </div>
                        <button wire:click="savePassword"
                            class="w-full rounded-xl bg-maroon py-2.5 text-sm font-semibold text-paper transition hover:bg-maroon/90">
                            Update Password
                        </button>
                    </div>
                @else
                    <p class="text-sm text-zinc-500">Klik "Ganti Password" untuk memperbarui password akun Anda.</p>
                @endif
            </div>
        </div>

        {{-- ===== RIGHT: HISTORY ===== --}}
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-zinc-200 bg-white shadow-sm">
                <div class="border-b border-zinc-100 px-6 py-4">
                    <h2 class="font-semibold text-ink">Riwayat Peminjaman</h2>
                </div>

                <div class="divide-y divide-zinc-100">
                    @forelse ($history as $reservation)
                        <div class="flex gap-3 px-6 py-4">
                            @if ($reservation->book?->cover)
                                <img src="{{ Storage::url($reservation->book->cover) }}" alt="{{ $reservation->book->title }}"
                                    class="h-16 w-11 shrink-0 rounded object-cover shadow-sm">
                            @else
                                <div class="flex h-16 w-11 shrink-0 items-center justify-center rounded bg-zinc-100">
                                    <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="line-clamp-1 font-medium text-ink">{{ $reservation->book?->title }}</p>
                                <p class="text-xs text-zinc-400">{{ $reservation->reservation_date?->format('d M Y') }}</p>
                            </div>
                            @php
                                $statusMap = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-blue-100 text-blue-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    'waiting_payment' => 'bg-orange-100 text-orange-700',
                                    'completed' => 'bg-emerald-100 text-emerald-700',
                                    'cancelled' => 'bg-zinc-100 text-zinc-500',
                                ];
                                $labels = [
                                    'pending' => 'Pending',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'waiting_payment' => 'Menunggu Bayar',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="self-start rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusMap[$reservation->status] ?? 'bg-zinc-100 text-zinc-500' }}">
                                {{ $labels[$reservation->status] ?? $reservation->status }}
                            </span>
                        </div>
                    @empty
                        <div class="py-16 text-center text-zinc-400">
                            <p>Belum ada riwayat peminjaman.</p>
                        </div>
                    @endforelse
                </div>

                @if ($hasMoreHistory)
                    <div class="border-t border-zinc-100 p-4 text-center">
                        <button wire:click="loadMoreHistory"
                            class="text-sm font-medium text-maroon hover:underline">
                            Tampilkan lebih banyak…
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        @notify.window="message = $event.detail[0].message; type = $event.detail[0].type; show = true; setTimeout(() => show = false, 3500)"
        x-show="show" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 z-50 rounded-xl px-5 py-3 text-sm font-medium text-white shadow-lg"
        :class="{ 'bg-emerald-600': type === 'success', 'bg-red-600': type === 'error' }">
        <span x-text="message"></span>
    </div>
</div>
