<?php

namespace App\Livewire\Admin;

use App\Models\Reservation;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Verifikasi Reservasi')]
class VerifikasiReservasi extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $isConfirmModalOpen = false;

    public bool $isRejectModalOpen = false;

    public ?Reservation $selectedReservation = null;

    public function updatedSearch(): void
    {
        $this->resetPage('pendingPage');
        $this->resetPage('historyPage');
    }

    public function confirmApproval(int $reservationId): void
    {
        $this->selectedReservation = Reservation::with(['user', 'book'])->find($reservationId);
        $this->isConfirmModalOpen = true;
    }

    public function executeApproval(): void
    {
        if ($this->selectedReservation) {
            $loanFee = (float) SystemSetting::getSetting('loan_fee', 0);
            $newStatus = $loanFee > 0 ? 'waiting_payment' : 'approved';

            $this->selectedReservation->update([
                'status' => $newStatus,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Kurangi stok buku jika disetujui (atau saat diambil? Untuk case ini kita kurangi saat disetujui)
            $this->selectedReservation->book->decrement('stock');

            $this->isConfirmModalOpen = false;
            $this->selectedReservation = null;

            $this->dispatch('swal:success', [
                'title' => 'Reservasi Disetujui',
                'text' => $newStatus === 'waiting_payment' ? 'Reservasi menunggu pembayaran dari anggota.' : 'Reservasi telah disetujui.',
            ]);
        }
    }

    public function confirmRejection(int $reservationId): void
    {
        $this->selectedReservation = Reservation::with(['user', 'book'])->find($reservationId);
        $this->isRejectModalOpen = true;
    }

    public function executeRejection(): void
    {
        if ($this->selectedReservation) {
            $this->selectedReservation->update([
                'status' => 'rejected',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            $this->isRejectModalOpen = false;
            $this->selectedReservation = null;

            $this->dispatch('swal:success', [
                'title' => 'Reservasi Ditolak',
                'text' => 'Reservasi telah ditolak.',
            ]);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $baseQuery = Reservation::with(['user', 'book'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($q2) {
                        $q2->where('name', 'like', "%{$this->search}%");
                    })->orWhere('reservation_code', 'like', "%{$this->search}%");
                });
            });

        $pendingReservations = (clone $baseQuery)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'pendingPage');

        $historyReservations = (clone $baseQuery)
            ->where('status', '!=', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'historyPage');

        return view('livewire.admin.verifikasi-reservasi', [
            'pendingReservations' => $pendingReservations,
            'historyReservations' => $historyReservations,
        ]);
    }
}
