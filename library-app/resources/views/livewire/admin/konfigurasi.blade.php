<div class="mx-auto max-w-4xl p-6">
    {{-- Header --}}
    <div class="mb-8 border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <h1 class="text-2xl font-semibold text-zinc-950 dark:text-white">Konfigurasi Sistem</h1>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Atur parameter perpustakaan seperti batas pinjaman, biaya, dan info pembayaran.</p>
    </div>

    <form wire:submit="saveSettings" class="space-y-8">
        {{-- Aturan Peminjaman --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950">
            <div class="border-b border-zinc-100 bg-zinc-50 px-6 py-4 dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Aturan Peminjaman & Biaya</h2>
                <p class="text-xs text-zinc-500">Konfigurasi batas pinjaman, biaya admin, dan denda.</p>
            </div>
            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                <flux:input wire:model="settings.loan_fee" type="number" label="Biaya Peminjaman (Rp)" 
                    description="Biaya yang harus dibayar saat reservasi disetujui (0 jika gratis)" min="0" required />
                
                <flux:input wire:model="settings.fine_per_day" type="number" label="Denda Keterlambatan per Hari (Rp)" 
                    description="Nominal denda per buku per hari keterlambatan" min="0" required />
                
                <flux:input wire:model="settings.max_books_per_loan" type="number" label="Maks. Buku per Reservasi" 
                    description="Batas maksimal buku dalam satu kali pinjam" min="1" required />
                
                <flux:input wire:model="settings.loan_duration_days" type="number" label="Durasi Pinjaman (Hari)" 
                    description="Waktu yang diberikan untuk meminjam buku" min="1" required />
            </div>
        </div>

        {{-- Info Rekening Pembayaran --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950">
            <div class="border-b border-zinc-100 bg-zinc-50 px-6 py-4 dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Informasi Rekening Bank</h2>
                <p class="text-xs text-zinc-500">Rekening tujuan untuk transfer biaya peminjaman atau denda.</p>
            </div>
            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                <flux:input wire:model="settings.bank_name" label="Nama Bank" placeholder="Contoh: BCA / Mandiri" />
                
                <flux:input wire:model="settings.bank_account_number" label="Nomor Rekening" placeholder="Masukkan no. rekening" />
                
                <div class="sm:col-span-2">
                    <flux:input wire:model="settings.bank_account_name" label="Nama Pemilik Rekening" placeholder="Atas nama siapa rekening tersebut" />
                </div>
            </div>
        </div>

        {{-- Identitas Perpustakaan --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950">
            <div class="border-b border-zinc-100 bg-zinc-50 px-6 py-4 dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Identitas Perpustakaan</h2>
                <p class="text-xs text-zinc-500">Informasi umum perpustakaan yang akan tampil di halaman depan.</p>
            </div>
            <div class="grid grid-cols-1 gap-6 p-6">
                <flux:input wire:model="settings.library_name" label="Nama Perpustakaan" required />
                
                <flux:textarea wire:model="settings.library_address" label="Alamat Lengkap" rows="3" />
                
                <flux:input wire:model="settings.library_phone" label="Nomor Telepon" />
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-2">
            <flux:button type="submit" wire:loading.attr="disabled" variant="primary" class="w-full sm:w-auto">
                <span wire:loading.remove wire:target="saveSettings">Simpan Konfigurasi</span>
                <span wire:loading wire:target="saveSettings">Menyimpan...</span>
            </flux:button>
        </div>
    </form>
</div>
