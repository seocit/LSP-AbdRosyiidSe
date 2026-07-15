<div class="mx-auto max-w-4xl px-6 py-10">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-ink">Peminjaman Saya</h1>
        <p class="mt-1 text-sm text-zinc-500">Riwayat dan status seluruh peminjaman buku Anda</p>
    </div>

    @if ($reservationGroups->isNotEmpty())
        @foreach ($reservationGroups as $date => $group)
            <div class="mb-8">
                {{-- Date Group Header --}}
                <div class="mb-3 flex items-center gap-3">
                    <div class="rounded-lg bg-maroon px-3 py-1 text-xs font-semibold text-paper">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                    </div>
                    <span class="text-xs text-zinc-400">{{ $group->count() }} buku</span>
                    <div class="h-px flex-1 bg-zinc-200"></div>
                </div>

                {{-- Reservation Cards --}}
                <div class="space-y-3">
                    @foreach ($group as $reservation)
                        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition hover:shadow-md">
                            <div class="flex gap-4 p-4">
                                {{-- Book Cover --}}
                                <div class="shrink-0">
                                    @if ($reservation->book?->cover)
                                        <img src="{{ Storage::url($reservation->book->cover) }}"
                                            alt="{{ $reservation->book->title }}"
                                            class="h-24 w-16 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div class="flex h-24 w-16 items-center justify-center rounded-lg bg-gradient-to-br from-maroon/10 to-brass/10">
                                            <svg class="size-7 text-maroon/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Details --}}
                                <div class="flex min-w-0 flex-1 flex-col justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-start justify-between gap-2">
                                            <div>
                                                <h3 class="font-semibold leading-snug text-ink">{{ $reservation->book?->title }}</h3>
                                                <p class="text-sm text-zinc-500">{{ $reservation->book?->author }}</p>
                                            </div>

                                            {{-- Status Badge --}}
                                            @php
                                                $statusMap = [
                                                    'pending' => ['bg-amber-100 text-amber-700', 'Menunggu Konfirmasi'],
                                                    'approved' => ['bg-blue-100 text-blue-700', 'Disetujui'],
                                                    'rejected' => ['bg-red-100 text-red-700', 'Ditolak'],
                                                    'waiting_payment' => ['bg-orange-100 text-orange-700', 'Menunggu Pembayaran'],
                                                    'completed' => ['bg-emerald-100 text-emerald-700', 'Selesai'],
                                                    'cancelled' => ['bg-zinc-100 text-zinc-500', 'Dibatalkan'],
                                                ];
                                                $badge = $statusMap[$reservation->status] ?? ['bg-zinc-100 text-zinc-500', $reservation->status];
                                            @endphp
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badge[0] }}">
                                                {{ $badge[1] }}
                                            </span>
                                        </div>

                                        <div class="mt-2 flex flex-wrap gap-4 text-xs text-zinc-400">
                                            <span>Kode: <span class="font-mono font-semibold text-zinc-600">{{ $reservation->reservation_code }}</span></span>
                                            @if ($reservation->pickup_date)
                                                <span>Ambil: {{ $reservation->pickup_date->format('d M Y') }}</span>
                                            @endif
                                            @if ($reservation->return_date)
                                                <span>Kembali: {{ $reservation->return_date->format('d M Y') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Payment CTA --}}
                                    @if ($reservation->status === 'waiting_payment' || ($reservation->status === 'approved' && $loanFee > 0 && (!$reservation->payment || $reservation->payment->status !== 'approved')))
                                        <div class="mt-3 flex items-center gap-3">
                                            @if ($reservation->payment && $reservation->payment->status === 'pending')
                                                <span class="text-xs text-amber-600">Bukti transfer menunggu verifikasi admin</span>
                                            @else
                                                <button wire:click="openPaymentModal({{ $reservation->id }})"
                                                    class="rounded-lg bg-brass px-4 py-2 text-xs font-semibold text-ink transition hover:bg-brass/90">
                                                    Bayar Sekarang
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="rounded-2xl border border-dashed border-zinc-300 py-24 text-center">
            <svg class="mx-auto mb-4 size-12 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-zinc-400">Belum ada peminjaman.</p>
            <a href="{{ route('member.peminjaman') }}"
                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-maroon px-6 py-2.5 text-sm font-semibold text-paper transition hover:bg-maroon/90"
                wire:navigate>
                Cari Buku Sekarang
            </a>
        </div>
    @endif

    {{-- ===== PAYMENT MODAL ===== --}}
    <flux:modal wire:model="isPaymentModalOpen" class="w-full max-w-md">
        @if ($selectedReservation)
            <div class="space-y-5 p-6">
                <div>
                    <h2 class="text-lg font-semibold text-ink">Pembayaran Peminjaman</h2>
                    <p class="mt-1 text-sm text-zinc-500">Upload bukti transfer ke rekening di bawah ini</p>
                </div>

                {{-- Bank Info --}}
                <div class="rounded-xl bg-zinc-50 p-4">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-zinc-400">Informasi Rekening</p>
                    <div class="space-y-1.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Bank</span>
                            <span class="font-semibold">{{ $bankName ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-500">No. Rekening</span>
                            <span class="font-mono font-semibold">{{ $bankAccount ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Atas Nama</span>
                            <span class="font-semibold">{{ $bankAccountName ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Total --}}
                <div class="rounded-xl border border-brass/30 bg-brass/5 p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600">Total Pembayaran</span>
                        <span class="font-display text-xl font-bold text-maroon">
                            Rp {{ number_format($loanFee, 0, ',', '.') }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-zinc-400">Buku: {{ $selectedReservation->book?->title }}</p>
                </div>

                {{-- Upload --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">Bukti Transfer</label>
                    <input type="file" wire:model="paymentProof" accept="image/*" id="payment-proof-upload"
                        class="w-full rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-700 file:mr-3 file:rounded-lg file:border-0 file:bg-maroon file:px-3 file:py-1 file:text-xs file:font-semibold file:text-paper">
                    @error('paymentProof')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <div wire:loading wire:target="paymentProof" class="mt-1 text-xs text-zinc-400">Mengupload...</div>
                </div>

                <div class="flex gap-3">
                    <flux:button wire:click="$set('isPaymentModalOpen', false)" variant="ghost" class="flex-1">Batal</flux:button>
                    <flux:button wire:click="submitPayment" wire:loading.attr="disabled" variant="primary" class="flex-1">
                        Kirim Bukti
                    </flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

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
        :class="{ 'bg-emerald-600': type === 'success', 'bg-red-600': type === 'error', 'bg-amber-500': type === 'warning' }">
        <span x-text="message"></span>
    </div>
</div>
