<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Verifikasi Pembayaran')]
class VerifikasiPembayaran extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $isConfirmModalOpen = false;

    public bool $isRejectModalOpen = false;

    public ?Payment $selectedPayment = null;

    public function updatedSearch(): void
    {
        $this->resetPage('pendingPage');
        $this->resetPage('historyPage');
    }

    public function confirmApproval(int $paymentId): void
    {
        $this->selectedPayment = Payment::with(['reservation.user', 'reservation.book'])->find($paymentId);
        $this->isConfirmModalOpen = true;
    }

    public function executeApproval(): void
    {
        if ($this->selectedPayment) {
            $this->selectedPayment->update([
                'status' => 'approved',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Update status reservasi jadi approved (buku siap diambil/sedang dipinjam)
            $this->selectedPayment->reservation->update([
                'status' => 'approved',
            ]);

            $this->isConfirmModalOpen = false;
            $this->selectedPayment = null;

            $this->dispatch('swal:success', [
                'title' => 'Pembayaran Disetujui',
                'text' => 'Status peminjaman berhasil diubah menjadi Disetujui.',
            ]);
        }
    }

    public function confirmRejection(int $paymentId): void
    {
        $this->selectedPayment = Payment::with(['reservation.user', 'reservation.book'])->find($paymentId);
        $this->isRejectModalOpen = true;
    }

    public function executeRejection(): void
    {
        if ($this->selectedPayment) {
            $this->selectedPayment->update([
                'status' => 'rejected',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Status reservasi dikembalikan ke waiting_payment agar user bisa upload ulang
            $this->selectedPayment->reservation->update([
                'status' => 'waiting_payment',
            ]);

            $this->isRejectModalOpen = false;
            $this->selectedPayment = null;

            $this->dispatch('swal:success', [
                'title' => 'Pembayaran Ditolak',
                'text' => 'Anggota perlu mengupload ulang bukti pembayaran.',
            ]);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $baseQuery = Payment::with(['reservation.user', 'reservation.book'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('reservation.user', function ($q2) {
                        $q2->where('name', 'like', "%{$this->search}%");
                    })->orWhere('payment_code', 'like', "%{$this->search}%")
                      ->orWhereHas('reservation', function ($q2) {
                          $q2->where('reservation_code', 'like', "%{$this->search}%");
                      });
                });
            });

        $pendingPayments = (clone $baseQuery)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'pendingPage');

        $historyPayments = (clone $baseQuery)
            ->where('status', '!=', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'historyPage');

        return view('livewire.admin.verifikasi-pembayaran', [
            'pendingPayments' => $pendingPayments,
            'historyPayments' => $historyPayments,
        ]);
    }
}
