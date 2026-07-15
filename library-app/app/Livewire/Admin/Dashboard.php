<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard Admin')]
class Dashboard extends Component
{
    public function returnBook($reservationId)
    {
        $reservation = Reservation::with('book')->find($reservationId);
        
        if ($reservation && $reservation->status === 'approved') {
            $reservation->update([
                'status' => 'returned',
                'return_date' => now(),
            ]);

            if ($reservation->book) {
                $reservation->book->increment('stock');
            }

            $this->dispatch('swal:success', [
                'title' => 'Buku Dikembalikan',
                'text' => 'Buku telah berhasil dikembalikan dan stok diperbarui.'
            ]);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $totalBooks = Book::sum('stock');
        $totalMembers = User::role('anggota')->count();
        $activeLoansCount = Reservation::where('status', 'approved')->count();
        
        $loanDuration = (int) SystemSetting::getSetting('loan_duration_days', 7);
        $overdueLoansCount = Reservation::where('status', 'approved')
                                ->where('reservation_date', '<', now()->subDays($loanDuration))
                                ->count();
                                
        $pendingReservationsCount = Reservation::where('status', 'pending')->count();

        $recentActivities = Reservation::with(['user', 'book'])
            ->latest('updated_at')
            ->take(5)
            ->get();
            
        $activeLoans = Reservation::with(['user', 'book'])
            ->where('status', 'approved')
            ->latest('updated_at')
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalBooks', 
            'totalMembers', 
            'activeLoansCount', 
            'overdueLoansCount',
            'pendingReservationsCount',
            'recentActivities',
            'activeLoans'
        ));
    }
}
