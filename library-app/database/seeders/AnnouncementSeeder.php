<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Gambar pengumuman menggunakan path dummy — ganti file di public/images/announcements/ saat demo.
     */
    public function run(): void
    {
        $admin = User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->first();

        $announcements = [
            [
                'title' => 'Selamat Datang di Perpustakaan Digital',
                'content' => 'Kami dengan bangga memperkenalkan sistem reservasi buku perpustakaan yang baru. Kini anggota dapat melakukan peminjaman buku secara online dengan mudah dan cepat. Silakan daftarkan diri Anda dan nikmati kemudahan layanan kami.',
                'image' => 'images/announcements/selamat-datang.jpg',
                'created_by' => $admin?->id,
            ],
            [
                'title' => 'Jam Operasional Perpustakaan',
                'content' => 'Perpustakaan kami buka setiap hari Senin–Jumat pukul 08.00–16.00 WIB dan Sabtu pukul 09.00–13.00 WIB. Pengambilan buku yang telah dipesan harap dilakukan sesuai jadwal yang ditentukan.',
                'image' => 'images/announcements/jam-operasional.jpg',
                'created_by' => $admin?->id,
            ],
            [
                'title' => 'Koleksi Buku Baru Telah Tersedia',
                'content' => 'Perpustakaan telah menambahkan 50 judul buku baru untuk berbagai kategori termasuk Sains & Teknologi, Fiksi, dan Ekonomi & Bisnis. Segera cek koleksi terbaru kami dan lakukan reservasi sekarang!',
                'image' => 'images/announcements/buku-baru.jpg',
                'created_by' => $admin?->id,
            ],
            [
                'title' => 'Pengumuman Denda Keterlambatan',
                'content' => 'Harap diperhatikan bahwa buku yang tidak dikembalikan tepat waktu akan dikenakan denda sesuai kebijakan perpustakaan. Pastikan Anda mengembalikan buku sebelum tanggal jatuh tempo untuk menghindari denda.',
                'image' => 'images/announcements/denda-keterlambatan.jpg',
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
