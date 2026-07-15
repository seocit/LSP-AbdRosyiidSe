<div class="space-y-6 p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Verifikasi Pembayaran</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Kelola bukti transfer pembayaran dari anggota.</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="flex flex-col gap-4 rounded-xl bg-zinc-50 p-4 sm:flex-row sm:items-center sm:justify-between dark:bg-zinc-900/50">
        <div class="w-full max-w-xs">
            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Cari nama, kode bayar/rsv..." clearable />
        </div>
    </div>

    {{-- Menunggu Verifikasi --}}
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Menunggu Verifikasi</h2>
    </div>
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kode Pembayaran</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Anggota</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Nominal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Bukti Transfer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-zinc-700 dark:text-zinc-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($pendingPayments as $payment)
                        <tr :key="$payment->id" class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4">
                                <p class="font-mono text-sm font-medium text-zinc-900 dark:text-white">{{ $payment->payment_code }}</p>
                                <p class="text-xs text-zinc-500">Rsv: {{ $payment->reservation?->reservation_code }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">{{ $payment->reservation?->user?->name }}</td>
                            <td class="px-6 py-4 font-mono text-sm font-semibold text-zinc-900 dark:text-white">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4" x-data="{ openPreview: false }">
                                @if ($payment->payment_proof)
                                    <button @click="openPreview = true" class="relative block h-16 w-16 overflow-hidden rounded-lg border border-zinc-200 shadow-sm transition hover:ring-2 hover:ring-maroon">
                                        <img src="{{ Storage::url($payment->payment_proof) }}" alt="Bukti Transfer" class="h-full w-full object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition hover:opacity-100">
                                            <flux:icon name="magnifying-glass-plus" class="size-5 text-white" />
                                        </div>
                                    </button>
                                    <div x-show="openPreview" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-ink/70 backdrop-blur-sm">
                                        <div @click.outside="openPreview = false" class="relative max-h-screen max-w-2xl rounded-lg bg-white p-2">
                                            <button @click="openPreview = false" class="absolute -right-3 -top-3 rounded-full bg-red-600 p-1.5 text-white shadow hover:bg-red-700">
                                                <flux:icon name="x-mark" class="size-5" />
                                            </button>
                                            <img src="{{ Storage::url($payment->payment_proof) }}" alt="Bukti Transfer Besar" class="max-h-[85vh] max-w-full rounded object-contain">
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs italic text-zinc-400">- Belum diupload -</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($payment->payment_proof)
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="confirmApproval({{ $payment->id }})" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">Setujui</button>
                                        <button wire:click="confirmRejection({{ $payment->id }})" class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak</button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td colspan="6" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Tidak ada data pembayaran yang menunggu verifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                {{ $pendingPayments->links() }}
            </div>
        </div>
    </div>

    {{-- Riwayat Verifikasi --}}
    <div class="mt-8 mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Riwayat Verifikasi</h2>
    </div>
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kode Pembayaran</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Anggota</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Nominal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Bukti Transfer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($historyPayments as $payment)
                        <tr :key="$payment->id" class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4">
                                <p class="font-mono text-sm font-medium text-zinc-900 dark:text-white">{{ $payment->payment_code }}</p>
                                <p class="text-xs text-zinc-500">Rsv: {{ $payment->reservation?->reservation_code }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">{{ $payment->reservation?->user?->name }}</td>
                            <td class="px-6 py-4 font-mono text-sm font-semibold text-zinc-900 dark:text-white">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4" x-data="{ openPreview: false }">
                                @if ($payment->payment_proof)
                                    <button @click="openPreview = true" class="relative block h-16 w-16 overflow-hidden rounded-lg border border-zinc-200 shadow-sm transition hover:ring-2 hover:ring-maroon">
                                        <img src="{{ Storage::url($payment->payment_proof) }}" alt="Bukti Transfer" class="h-full w-full object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition hover:opacity-100">
                                            <flux:icon name="magnifying-glass-plus" class="size-5 text-white" />
                                        </div>
                                    </button>
                                    <div x-show="openPreview" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-ink/70 backdrop-blur-sm">
                                        <div @click.outside="openPreview = false" class="relative max-h-screen max-w-2xl rounded-lg bg-white p-2">
                                            <button @click="openPreview = false" class="absolute -right-3 -top-3 rounded-full bg-red-600 p-1.5 text-white shadow hover:bg-red-700">
                                                <flux:icon name="x-mark" class="size-5" />
                                            </button>
                                            <img src="{{ Storage::url($payment->payment_proof) }}" alt="Bukti Transfer Besar" class="max-h-[85vh] max-w-full rounded object-contain">
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs italic text-zinc-400">- Belum diupload -</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusMap = [
                                        'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $statusMap[$payment->status] ?? '' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Belum ada riwayat verifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                {{ $historyPayments->links() }}
            </div>
        </div>
    </div>

    {{-- Confirm Modal --}}
    <flux:modal wire:model="isConfirmModalOpen" class="w-full max-w-sm space-y-6 p-6 text-center">
        <div class="flex flex-col items-center">
            <div class="mb-3 rounded-full bg-blue-50 p-3 text-blue-600 dark:bg-zinc-900 dark:text-blue-400">
                <flux:icon name="check-circle" class="size-8" />
            </div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Setujui Pembayaran</h2>
            <p class="mt-1 text-sm text-zinc-500">
                Apakah bukti transfer <span class="font-semibold text-zinc-900 dark:text-white">{{ $selectedPayment?->payment_code }}</span> sudah valid dan dana telah diterima?
                <br>
                Status reservasi akan diubah menjadi Selesai.
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isConfirmModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeApproval" wire:loading.attr="disabled" variant="primary" class="w-full">Ya, Valid</flux:button>
        </div>
    </flux:modal>

    {{-- Reject Modal --}}
    <flux:modal wire:model="isRejectModalOpen" class="w-full max-w-sm space-y-6 p-6 text-center">
        <div class="flex flex-col items-center">
            <div class="mb-3 rounded-full bg-red-50 p-3 text-red-600 dark:bg-zinc-900 dark:text-red-400">
                <flux:icon name="x-circle" class="size-8" />
            </div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Tolak Pembayaran</h2>
            <p class="mt-1 text-sm text-zinc-500">
                Apakah Anda yakin bukti transfer ini tidak valid?
                <br>
                Anggota harus mengupload ulang bukti transfer.
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isRejectModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeRejection" wire:loading.attr="disabled" variant="danger" class="w-full">Ya, Tolak</flux:button>
        </div>
    </flux:modal>
</div>
