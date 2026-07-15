<div class="space-y-6 p-6">
    {{-- Include Quill CSS & JS only here --}}
    @push('styles')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @endpush
    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    @endpush

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Kelola Pengumuman</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Buat dan kelola informasi yang tampil di halaman utama.</p>
        </div>
        <flux:button wire:click="create" variant="primary" icon="plus">Tambah Pengumuman</flux:button>
    </div>

    {{-- Filter & Search --}}
    <div class="flex items-center justify-between gap-4 rounded-xl bg-zinc-50 p-4 dark:bg-zinc-900/50">
        <div class="w-full max-w-sm">
            <flux:input wire:model.live.debounce.500ms="search" icon="magnifying-glass" placeholder="Cari judul..." clearable />
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Gambar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Judul</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Penulis</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tanggal</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-zinc-700 dark:text-zinc-300">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-800 dark:bg-zinc-950">
                    @forelse ($announcements as $ann)
                        <tr :key="$ann->id" class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-6 py-4">
                                @if ($ann->image)
                                    <img src="{{ Storage::url($ann->image) }}" alt="{{ $ann->title }}" class="h-12 w-20 rounded object-cover shadow-sm">
                                @else
                                    <div class="flex h-12 w-20 items-center justify-center rounded bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                        <flux:icon name="photo" class="size-5" />
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="line-clamp-2 text-sm font-medium text-zinc-900 dark:text-white">{{ $ann->title }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $ann->creator?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $ann->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="edit({{ $ann->id }})" class="rounded p-1.5 text-zinc-400 transition hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-500/10">
                                        <flux:icon name="pencil-square" class="size-5" />
                                    </button>
                                    <button wire:click="confirmDelete({{ $ann->id }})" class="rounded p-1.5 text-zinc-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10">
                                        <flux:icon name="trash" class="size-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                Belum ada pengumuman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>

    {{-- Form Modal --}}
    <flux:modal wire:model="isFormModalOpen" class="w-full max-w-3xl space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">{{ $isEdit ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' }}</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Pastikan informasi sudah benar sebelum disimpan.</p>
        </div>

        <form wire:submit="save" class="space-y-5">
            <div>
                <flux:input wire:model="title" label="Judul Pengumuman" placeholder="Masukkan judul..." required />
            </div>

            {{-- Rich Text Editor (Quill.js integration via Alpine) --}}
            <div wire:ignore 
                x-data="{
                    content: @entangle('content'),
                    quill: null
                }"
                x-init="
                    quill = new Quill($refs.quillEditor, {
                        theme: 'snow',
                        placeholder: 'Tulis isi pengumuman...',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['link', 'clean']
                            ]
                        }
                    });
                    
                    // Listen to Livewire event to set initial content
                    window.addEventListener('init-quill', (e) => {
                        let html = e.detail[0].content;
                        quill.root.innerHTML = html;
                    });
                    
                    // Update Alpine & Livewire property on change
                    quill.on('text-change', function () {
                        content = quill.root.innerHTML;
                    });
                "
            >
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Isi Pengumuman</label>
                <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
                    {{-- Toolbar will be injected here by Quill --}}
                    <div x-ref="quillEditor" class="min-h-[200px]"></div>
                </div>
            </div>
            @error('content') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

            {{-- Image Upload --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Gambar/Poster (Opsional)</label>
                <div class="mt-1 flex items-center gap-4">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="h-20 w-32 rounded object-cover border border-zinc-200">
                    @elseif ($oldImage)
                        <img src="{{ Storage::url($oldImage) }}" class="h-20 w-32 rounded object-cover border border-zinc-200">
                    @endif
                    <input type="file" wire:model="image" accept="image/*"
                        class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-500/10 dark:file:text-blue-400">
                </div>
                @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                <div wire:loading wire:target="image" class="mt-1 text-xs text-zinc-500">Mengupload...</div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <flux:button wire:click="$set('isFormModalOpen', false)" variant="ghost">Batal</flux:button>
                <flux:button type="submit" wire:loading.attr="disabled" wire:target="save, image" variant="primary">
                    Simpan Pengumuman
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
            <h2 class="text-lg font-semibold text-zinc-950 dark:text-white">Hapus Pengumuman</h2>
            <p class="mt-1 text-sm text-zinc-500">
                Yakin ingin menghapus pengumuman <span class="font-semibold text-zinc-900 dark:text-white">{{ $announcementToDelete?->title }}</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <flux:button wire:click="$set('isDeleteModalOpen', false)" variant="ghost" class="w-full">Batal</flux:button>
            <flux:button wire:click="executeDelete" wire:loading.attr="disabled" variant="danger" class="w-full">Ya, Hapus</flux:button>
        </div>
    </flux:modal>
</div>
