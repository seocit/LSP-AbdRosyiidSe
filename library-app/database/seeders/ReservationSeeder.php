<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Hanya data reservasi dasar (pending & cancelled).
     * Verifikasi, pembayaran, dan pengembalian dilakukan melalui UI saat demo.
     */
    public function run(): void
    {
        $members = User::whereHas('roles', fn ($q) => $q->where('name', 'anggota'))
            ->where('status', 'active')
            ->get();
        $books = Book::all();

        if ($members->isEmpty() || $books->isEmpty()) {
            return;
        }

        $member1 = $members->get(0);
        $member2 = $members->get(1);
        $member3 = $members->get(2) ?? $member1;

        // Reservasi PENDING — anggota 1, menunggu persetujuan admin
        Reservation::create([
            'reservation_code' => Reservation::generateCode(),
            'user_id' => $member1->id,
            'book_id' => $books->get(0)->id,
            'reservation_date' => Carbon::today(),
            'pickup_date' => Carbon::today()->addDays(1),
            'return_date' => Carbon::today()->addDays(8),
            'note' => 'Mohon diproses segera, terima kasih.',
            'status' => 'pending',
        ]);

        // Reservasi PENDING — anggota 2
        Reservation::create([
            'reservation_code' => Reservation::generateCode(),
            'user_id' => $member2->id,
            'book_id' => $books->get(2)->id,
            'reservation_date' => Carbon::today()->subDay(),
            'pickup_date' => Carbon::today()->addDays(2),
            'return_date' => Carbon::today()->addDays(9),
            'note' => null,
            'status' => 'pending',
        ]);

        // Reservasi PENDING — anggota 3
        Reservation::create([
            'reservation_code' => Reservation::generateCode(),
            'user_id' => $member3->id,
            'book_id' => $books->get(4)->id,
            'reservation_date' => Carbon::today(),
            'pickup_date' => Carbon::today()->addDays(1),
            'return_date' => Carbon::today()->addDays(8),
            'note' => 'Butuh buku ini untuk tugas akhir.',
            'status' => 'pending',
        ]);

        // Reservasi CANCELLED — dibatalkan oleh anggota
        Reservation::create([
            'reservation_code' => Reservation::generateCode(),
            'user_id' => $member1->id,
            'book_id' => $books->get(6)->id,
            'reservation_date' => Carbon::today()->subDays(3),
            'pickup_date' => null,
            'return_date' => null,
            'note' => null,
            'status' => 'cancelled',
        ]);
    }
}
