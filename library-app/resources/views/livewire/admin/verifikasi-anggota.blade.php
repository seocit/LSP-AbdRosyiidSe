<div class="p-6 space-y-6">
    {{-- 1. HEADER --}}
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Verifikasi Anggota Baru</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Setujui pendaftaran akun agar user mendapatkan akses
                menu peminjaman buku.</p>
        </div>


    </div>

    {{-- 2. TOOLS FILTER PENCARIAN (Menggunakan Flux Component) --}}
    <div class="flex items-center justify-between gap-4 bg-zinc-50 p-4 rounded-xl dark:bg-zinc-900/50">
        <div class="w-full max-w-xs">
            {{-- Menggunakan Flux Input dengan ikon pencarian --}}
            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Cari nama atau email pendaftar..."
                clearable />
        </div>

        <div class="flex items-center gap-2">
            {{-- Tombol filter tambahan jika dibutuhkan ke depannya --}}
            <flux:button variant="subtle" icon="funnel">Filter</flux:button>
        </div>
    </div>


    {{-- 3. TABEL DATA ANGGOTA BARU --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Nama Lengkap
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Tanggal Daftar
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($users as $user)
                        {{-- Dummy Row 1 --}}
                        <tr :key="$user->id" class="hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                {{$user->name}}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{$user->email}}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{$user->created_at->format('d M Y')}}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                    {{$user->status}}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="confirmVerification({{$user->id}})"
                                        class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                        Verifikasi
                                    </button>

                                    <button wire:click="confirmRejection({{ $user->id }})"
                                        class="inline-flex items-center rounded-lg bg-red-600 p-2 text-white hover:bg-red-700">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="flex  hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                tidak ada user yang menunggu verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>


    <!-- CONFIRM MODAL -->
    <flux:modal wire:model="isConfirmModalOpen" class="w-full max-w-sm p-6 space-y-6 text-center">
        <div class="flex flex-col items-center">
            {{-- Ikon Variasi --}}
            <div class="p-3 bg-blue-50 text-blue-600 rounded-full dark:bg-zinc-900 dark:text-blue-400 mb-3">
                <flux:icon name="exclamation-triangle" class="w-8 h-8" />
            </div>

            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Konfirmasi Verifikasi</h2>
            <p class="text-sm text-zinc-500 mt-1">
                Apakah kamu yakin ingin mengaktifkan akun
                <span class="font-semibold text-zinc-900 dark:text-white">
                    {{ $selectedUserForVerification?->name }}
                </span> dan memberikan hak akses sebagai Anggota?
            </p>
        </div>

        <div class="flex justify-center gap-3">
            {{-- Tombol Batal --}}
            <flux:button wire:click="$set('isConfirmModalOpen', false)" variant="ghost" class="w-full">Batal
            </flux:button>
            {{-- Tombol Eksekusi --}}
            <flux:button wire:click="executeVerification" wire:loading.attr="disabled" variant="primary" class="w-full">
                Ya, Verifikasi</flux:button>
        </div>
    </flux:modal>

    <!-- REJECT MODAL -->
    <flux:modal wire:model="isRejectModalOpen" class="w-full max-w-sm p-6 space-y-6 text-center">
        <div class="flex flex-col items-center">
            {{-- Ikon Peringatan Merah --}}
            <div class="p-3 bg-red-50 text-red-600 rounded-full dark:bg-zinc-900 dark:text-red-400 mb-3">
                <flux:icon name="x-circle" class="w-8 h-8" />
            </div>

            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Tolak Pendaftaran</h2>
            <p class="text-sm text-zinc-500 mt-1">
                Apakah kamu yakin ingin menolak pendaftaran akun
                <span class="font-semibold text-zinc-900 dark:text-white">
                    {{ $selectedUserForRejection?->name }}
                </span>?
            </p>
        </div>

        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isRejectModalOpen', false)" variant="ghost" class="w-full">
                Batal
            </flux:button>
            <flux:button wire:click="executeRejection" wire:loading.attr="disabled" variant="danger" class="w-full">Ya,
                Tolak
            </flux:button>
        </div>
    </flux:modal>
</div>