<div class="space-y-6 p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Kelola Buku</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Manajemen katalog dan inventaris buku perpustakaan.</p>
        </div>
        <flux:button wire:click="create" variant="primary" icon="plus">Tambah Buku</flux:button>
    </div>

    {{-- Filter & Search --}}
    <div class="flex flex-col gap-4 rounded-xl bg-zinc-50 p-4 sm:flex-row sm:items-center sm:justify-between dark:bg-zinc-900/50">
        <div class="w-full max-w-xs">
            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Cari judul, penulis, ISBN..." clearable />
        </div>

        <div class="w-full sm:w-48">
            <flux:select wire:model.live="categoryFilter">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </flux:select>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Stok</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">ISBN</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-zinc-700 dark:text-zinc-300">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($books as $book)
                        <tr :key="$book->id" class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($book->cover)
                                        <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->title }}" class="h-16 w-11 rounded object-cover shadow-sm">
                                    @else
                                        <div class="flex h-16 w-11 items-center justify-center rounded bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                            <flux:icon name="book-open" class="size-5" />
                                        </div>
                                    @endif
                                    <div>
                                        <p class="line-clamp-2 text-sm font-medium text-zinc-900 dark:text-white">{{ $book->title }}</p>
                                        <p class="text-xs text-zinc-500">{{ $book->author }} • {{ $book->publish_year }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $book->category?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($book->stock > 0)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                                        {{ $book->stock }} Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-500/20 dark:text-red-400">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-mono text-zinc-600 dark:text-zinc-400">
                                {{ $book->isbn ?: '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="edit({{ $book->id }})" class="rounded p-1.5 text-zinc-400 transition hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-500/10">
                                        <flux:icon name="pencil-square" class="size-5" />
                                    </button>
                                    <button wire:click="confirmDelete({{ $book->id }})" class="rounded p-1.5 text-zinc-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10">
                                        <flux:icon name="trash" class="size-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                Belum ada buku yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                {{ $books->links() }}
            </div>
        </div>
    </div>

    {{-- Form Modal --}}
    <flux:modal wire:model="isFormModalOpen" class="w-full max-w-4xl space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">{{ $isEdit ? 'Edit Buku' : 'Tambah Buku Baru' }}</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Masukkan detail informasi buku.</p>
        </div>

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Left Column --}}
                <div class="space-y-5">
                    <flux:input wire:model="title" label="Judul Buku" placeholder="Masukkan judul buku..." required />
                    <flux:input wire:model="author" label="Penulis" placeholder="Nama penulis..." required />
                    
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="publisher" label="Penerbit" placeholder="Nama penerbit..." required />
                        <flux:input wire:model="publish_year" label="Tahun Terbit" placeholder="2024" maxlength="4" required />
                    </div>

                    <flux:select wire:model="category_id" label="Kategori" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </flux:select>
                </div>

                {{-- Right Column --}}
                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="isbn" label="ISBN" placeholder="Nomor ISBN (opsional)..." />
                        <flux:input wire:model="stock" type="number" label="Stok Tersedia" min="0" required />
                    </div>

                    <flux:textarea wire:model="description" label="Deskripsi / Sinopsis" placeholder="Tuliskan deskripsi singkat..." rows="4" />

                    {{-- Image Upload --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Sampul Buku</label>
                        <div class="mt-1 flex items-center gap-4">
                            @if ($cover)
                                <img src="{{ $cover->temporaryUrl() }}" class="h-24 w-16 rounded object-cover border border-zinc-200 shadow-sm">
                            @elseif ($oldCover)
                                <img src="{{ Storage::url($oldCover) }}" class="h-24 w-16 rounded object-cover border border-zinc-200 shadow-sm">
                            @endif
                            <input type="file" wire:model="cover" accept="image/*"
                                class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-full file:border-0 file:bg-maroon/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-maroon hover:file:bg-maroon/20 dark:file:bg-maroon/20 dark:file:text-maroon">
                        </div>
                        @error('cover') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="cover" class="mt-1 text-xs text-zinc-500">Mengupload...</div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:click="$set('isFormModalOpen', false)" variant="ghost">Batal</flux:button>
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="save, cover" variant="primary">
                    Simpan Buku
                </flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Modal --}}
    <flux:modal wire:model="isDeleteModalOpen" class="w-full max-w-sm space-y-6 p-6 text-center">
        <div class="flex flex-col items-center">
            <div class="mb-3 rounded-full bg-red-50 p-3 text-red-600 dark:bg-zinc-900 dark:text-red-400">
                <flux:icon name="trash" class="size-8" />
            </div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Hapus Buku</h2>
            <p class="mt-1 text-sm text-zinc-500">
                Yakin ingin menghapus buku <span class="font-semibold text-zinc-900 dark:text-white">{{ $bookToDelete?->title }}</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isDeleteModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeDelete" wire:loading.attr="disabled" variant="danger" class="w-full">Ya, Hapus</flux:button>
        </div>
    </flux:modal>
</div>
