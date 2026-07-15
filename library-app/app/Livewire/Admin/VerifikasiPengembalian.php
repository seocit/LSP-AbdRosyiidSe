<?php

namespace App\Livewire\Admin;

use App\Models\Reservation;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Pengembalian Buku')]
class VerifikasiPengembalian extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $isReturnModalOpen = false;

    public ?Reservation $selectedReservation = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmReturn(int $reservationId): void
    {
        $this->selectedReservation = Reservation::with(['book', 'user'])->find($reservationId);
        $this->isReturnModalOpen = true;
    }

    public function executeReturn(): void
    {
        if (! $this->selectedReservation || $this->selectedReservation->status !== 'approved') {
            $this->isReturnModalOpen = false;

            return;
        }

        $this->selectedReservation->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        if ($this->selectedReservation->book) {
            $this->selectedReservation->book->increment('stock');
        }

        $this->isReturnModalOpen = false;
        $this->selectedReservation = null;

        $this->dispatch('swal:success', [
            'title' => 'Buku Dikembalikan',
            'text' => 'Buku telah berhasil dikembalikan dan stok diperbarui.',
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        $activeLoans = Reservation::with(['user', 'book'])
            ->where('status', 'approved')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($q2) {
                        $q2->where('name', 'like', "%{$this->search}%");
                    })->orWhere('reservation_code', 'like', "%{$this->search}%");
                });
            })
            ->latest('updated_at')
            ->paginate(10);

        return view('livewire.admin.verifikasi-pengembalian', [
            'activeLoans' => $activeLoans,
        ]);
    }
}
