<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-ink">Pengembalian Buku</h1>
            <p class="text-zinc-500 mt-1">Konfirmasi pengembalian buku dari anggota perpustakaan.</p>
        </div>
        
        <!-- Search -->
        <div class="relative w-full sm:w-64">
            <svg class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari anggota atau kode..."
                class="w-full rounded-xl border border-zinc-200 bg-white py-2 pl-9 pr-4 text-sm text-zinc-700 shadow-sm transition focus:border-maroon focus:outline-none focus:ring-2 focus:ring-maroon/20">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-600">
                <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode Reservasi</th>
                        <th class="px-6 py-4 font-semibold">Anggota</th>
                        <th class="px-6 py-4 font-semibold">Buku</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Pinjam</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($activeLoans as $loan)
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-semibold text-zinc-600 bg-zinc-100 px-2 py-1 rounded">{{ $loan->reservation_code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-ink">{{ $loan->user->name ?? 'Anonim' }}</div>
                                <div class="text-xs text-zinc-400">{{ $loan->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-ink line-clamp-1">{{ $loan->book->title ?? 'Buku Tidak Ditemukan' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $loan->reservation_date ? $loan->reservation_date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button 
                                    wire:click="confirmReturn({{ $loan->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg transition"
                                >
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Terima Buku
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-zinc-400">
                                <svg class="size-12 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <p>Tidak ada data peminjaman aktif yang cocok.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($activeLoans->hasPages())
            <div class="border-t border-zinc-100 p-4">
                {{ $activeLoans->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL KONFIRMASI PENGEMBALIAN --}}
    <flux:modal wire:model="isReturnModalOpen" class="w-full max-w-md p-0 overflow-hidden">
        <div class="bg-gradient-to-br from-maroon to-[#4a1a1a] p-6 text-center">
            <div class="mx-auto mb-3 flex size-14 items-center justify-center rounded-full bg-white/10 text-white">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-white">Konfirmasi Pengembalian</h2>
            <p class="mt-1 text-sm text-white/70">Pastikan buku sudah diterima secara fisik sebelum mengkonfirmasi.</p>
        </div>

        <div class="space-y-4 bg-white p-6">
            @if($selectedReservation)
                <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-lg bg-maroon/10">
                            <svg class="size-4 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Buku</p>
                            <p class="text-sm font-semibold text-ink">{{ $selectedReservation->book->title ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-lg bg-maroon/10">
                            <svg class="size-4 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Anggota</p>
                            <p class="text-sm font-semibold text-ink">{{ $selectedReservation->user->name ?? '-' }}</p>
                            <p class="text-xs text-zinc-400">{{ $selectedReservation->user->email ?? '' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 border-t border-zinc-200 pt-3">
                        <div class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-lg bg-maroon/10">
                            <svg class="size-4 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Kode Reservasi</p>
                            <p class="font-mono text-sm font-semibold text-ink">{{ $selectedReservation->reservation_code }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex gap-3">
                <flux:button
                    wire:click="$set('isReturnModalOpen', false)"
                    variant="ghost"
                    class="w-full"
                >
                    Batal
                </flux:button>
                <flux:button
                    wire:click="executeReturn"
                    wire:loading.attr="disabled"
                    class="w-full !bg-maroon hover:!bg-maroon/90 !text-white"
                >
                    <span wire:loading.remove wire:target="executeReturn">Ya, Konfirmasi Pengembalian</span>
                    <span wire:loading wire:target="executeReturn">Memproses...</span>
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
