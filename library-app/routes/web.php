<?php

use App\Livewire\Admin\KelolaAnnouncement;
use App\Livewire\Admin\KelolaBuku;
use App\Livewire\Admin\Konfigurasi;
use App\Livewire\Admin\VerifikasiAnggota;
use App\Livewire\Admin\VerifikasiPembayaran;
use App\Livewire\Admin\VerifikasiReservasi;
use App\Livewire\Announcements\Index;
use App\Livewire\Member\ListPeminjaman;
use App\Livewire\Member\PeminjamanBuku;
use App\Livewire\Member\Profile;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('home');
Route::get('/pengumuman', Index::class)->name('announcements.index');

// Member Routes
Route::middleware(['auth', 'verified', 'role:anggota'])->group(function () {
    Route::get('/peminjaman', PeminjamanBuku::class)->name('member.peminjaman');
    Route::get('/peminjaman/list', ListPeminjaman::class)->name('member.list-peminjaman');
    Route::get('/profile', Profile::class)->name('member.profile');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('admin/verifikasi-anggota', VerifikasiAnggota::class)->name('admin.verifikasi-anggota');
    Route::get('admin/verifikasi-reservasi', VerifikasiReservasi::class)->name('admin.verifikasi-reservasi');
    Route::get('admin/verifikasi-pembayaran', VerifikasiPembayaran::class)->name('admin.verifikasi-pembayaran');
    Route::get('admin/verifikasi-pengembalian', \App\Livewire\Admin\VerifikasiPengembalian::class)->name('admin.verifikasi-pengembalian');
    Route::get('admin/pengumuman', KelolaAnnouncement::class)->name('admin.pengumuman');
    Route::get('admin/buku', KelolaBuku::class)->name('admin.buku');
    Route::get('admin/kelola-anggota', \App\Livewire\Admin\KelolaAnggota::class)->name('admin.kelola-anggota');
    Route::get('admin/konfigurasi', Konfigurasi::class)->name('admin.konfigurasi');
});

require __DIR__ . '/settings.php';
