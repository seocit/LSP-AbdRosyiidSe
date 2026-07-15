<div class="p-6 space-y-6">
    {{-- 1. HEADER --}}
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Kelola Anggota</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Kelola status anggota perpustakaan dan data pengguna.</p>
        </div>
    </div>

    {{-- 2. TOOLS FILTER PENCARIAN --}}
    <div class="flex items-center justify-between gap-4 bg-zinc-50 p-4 rounded-xl dark:bg-zinc-900/50">
        <div class="w-full max-w-xs">
            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Cari nama atau email..." clearable />
        </div>
    </div>

    {{-- 3. TABEL DATA ANGGOTA --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-zinc-700 dark:text-zinc-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium 
                                    {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 
                                      ($user->status === 'inactive' ? 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400' : 
                                      'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400') }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    @if($user->status !== 'active')
                                        <button wire:click="confirmStatusChange({{ $user->id }}, 'active')" class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700">Aktifkan</button>
                                    @endif
                                    @if($user->status !== 'inactive')
                                        <button wire:click="confirmStatusChange({{ $user->id }}, 'inactive')" class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Nonaktifkan</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">
                            <td colspan="5" class="px-6 py-4 text-center text-zinc-600 dark:text-zinc-400">Tidak ada pengguna yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-800">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- CONFIRM MODAL -->
    <flux:modal wire:model="isConfirmModalOpen" class="w-full max-w-sm p-6 space-y-6 text-center">
        <div class="flex flex-col items-center">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-full dark:bg-zinc-900 dark:text-blue-400 mb-3">
                <flux:icon name="exclamation-triangle" class="w-8 h-8" />
            </div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Konfirmasi Ubah Status</h2>
            <p class="text-sm text-zinc-500 mt-1">
                Apakah kamu yakin ingin mengubah status 
                <span class="font-semibold text-zinc-900 dark:text-white">{{ $selectedUser?->name }}</span> 
                menjadi 
                <span class="font-semibold text-zinc-900 dark:text-white">{{ ucfirst($newStatus) }}</span>?
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isConfirmModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeStatusChange" wire:loading.attr="disabled" variant="primary" class="w-full">Ya, Ubah</flux:button>
        </div>
    </flux:modal>
</div>
