<div class="space-y-6 p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Verifikasi Reservasi</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Kelola permohonan peminjaman buku dari anggota.</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="flex flex-col gap-4 rounded-xl bg-zinc-50 p-4 sm:flex-row sm:items-center sm:justify-between dark:bg-zinc-900/50">
        <div class="w-full max-w-xs">
            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Cari nama atau kode..." clearable />
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kode</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Anggota</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-zinc-700 dark:text-zinc-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($pendingReservations as $rsv)
                        <tr :key="$rsv->id" class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4 font-mono text-sm font-medium text-zinc-900 dark:text-white">{{ $rsv->reservation_code }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">{{ $rsv->user?->name }}</td>
                            <td class="px-6 py-4">
                                <p class="line-clamp-1 text-sm font-medium text-zinc-900 dark:text-white">{{ $rsv->book?->title }}</p>
                                <p class="text-xs text-zinc-500">Stok sisa: {{ $rsv->book?->stock }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">{{ $rsv->reservation_date?->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="confirmApproval({{ $rsv->id }})" class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">Setujui</button>
                                    <button wire:click="confirmRejection({{ $rsv->id }})" class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td colspan="6" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Tidak ada reservasi yang menunggu verifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                {{ $pendingReservations->links() }}
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kode</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Anggota</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($historyReservations as $rsv)
                        <tr :key="$rsv->id" class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4 font-mono text-sm font-medium text-zinc-900 dark:text-white">{{ $rsv->reservation_code }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">{{ $rsv->user?->name }}</td>
                            <td class="px-6 py-4">
                                <p class="line-clamp-1 text-sm font-medium text-zinc-900 dark:text-white">{{ $rsv->book?->title }}</p>
                                <p class="text-xs text-zinc-500">Diverifikasi pada: {{ $rsv->verified_at?->format('d M Y H:i') ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">{{ $rsv->reservation_date?->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusMap = [
                                        'approved' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400',
                                        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
                                        'waiting_payment' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400',
                                        'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                        'cancelled' => 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $statusMap[$rsv->status] ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $rsv->status)) }}
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
                {{ $historyReservations->links() }}
            </div>
        </div>
    </div>

    {{-- Confirm Modal --}}
    <flux:modal wire:model="isConfirmModalOpen" class="w-full max-w-sm space-y-6 p-6 text-center">
        <div class="flex flex-col items-center">
            <div class="mb-3 rounded-full bg-blue-50 p-3 text-blue-600 dark:bg-zinc-900 dark:text-blue-400">
                <flux:icon name="check-circle" class="size-8" />
            </div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Setujui Reservasi</h2>
            <p class="mt-1 text-sm text-zinc-500">
                Apakah Anda yakin ingin menyetujui peminjaman buku
                <span class="font-semibold text-zinc-900 dark:text-white">{{ $selectedReservation?->book?->title }}</span>
                oleh <span class="font-semibold text-zinc-900 dark:text-white">{{ $selectedReservation?->user?->name }}</span>?
                <br><br>
                <span class="text-xs text-amber-600">Catatan: Stok buku akan dikurangi 1.</span>
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isConfirmModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeApproval" wire:loading.attr="disabled" variant="primary" class="w-full">Ya, Setujui</flux:button>
        </div>
    </flux:modal>

    {{-- Reject Modal --}}
    <flux:modal wire:model="isRejectModalOpen" class="w-full max-w-sm space-y-6 p-6 text-center">
        <div class="flex flex-col items-center">
            <div class="mb-3 rounded-full bg-red-50 p-3 text-red-600 dark:bg-zinc-900 dark:text-red-400">
                <flux:icon name="x-circle" class="size-8" />
            </div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Tolak Reservasi</h2>
            <p class="mt-1 text-sm text-zinc-500">
                Apakah Anda yakin ingin menolak peminjaman ini?
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isRejectModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeRejection" wire:loading.attr="disabled" variant="danger" class="w-full">Ya, Tolak</flux:button>
        </div>
    </flux:modal>
</div>
