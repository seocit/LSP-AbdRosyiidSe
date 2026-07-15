<?php

namespace App\Livewire\Member;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.member')]
#[Title('Peminjaman Saya')]
class ListPeminjaman extends Component
{
    use WithFileUploads;

    public bool $isPaymentModalOpen = false;

    public ?Reservation $selectedReservation = null;

    public $paymentProof = null;

    public function openPaymentModal(int $reservationId): void
    {
        $this->selectedReservation = Reservation::with(['book', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($reservationId);

        $this->paymentProof = null;
        $this->isPaymentModalOpen = true;
    }

    public function submitPayment(): void
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048',
        ], [
            'paymentProof.required' => 'Bukti transfer wajib diunggah.',
            'paymentProof.image' => 'File harus berupa gambar.',
            'paymentProof.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $this->paymentProof->store('payment-proofs', 'public');

        $loanFee = (float) SystemSetting::getSetting('loan_fee', 0);

        Payment::updateOrCreate(
            ['reservation_id' => $this->selectedReservation->id],
            [
                'payment_code' => Payment::generateCode(),
                'amount' => $loanFee,
                'payment_proof' => $path,
                'status' => 'pending',
            ]
        );

        $this->isPaymentModalOpen = false;
        $this->selectedReservation = null;
        $this->paymentProof = null;

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Bukti pembayaran berhasil dikirim.']);
    }

    public function render(): \Illuminate\View\View
    {
        $reservations = Reservation::with(['book.category', 'payment'])
            ->where('user_id', Auth::id())
            ->latest('reservation_date')
            ->get()
            ->groupBy(fn ($r) => $r->reservation_date?->format('Y-m-d'));

        $bankName = SystemSetting::getSetting('bank_name', '-');
        $bankAccount = SystemSetting::getSetting('bank_account_number', '-');
        $bankAccountName = SystemSetting::getSetting('bank_account_name', '-');
        $loanFee = (float) SystemSetting::getSetting('loan_fee', 0);

        return view('livewire.member.list-peminjaman', [
            'reservationGroups' => $reservations,
            'bankName' => $bankName,
            'bankAccount' => $bankAccount,
            'bankAccountName' => $bankAccountName,
            'loanFee' => $loanFee,
        ]);
    }
}
