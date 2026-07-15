<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class VerifikasiAnggota extends Component
{

    public $search = '';
    public $pageTitle;

    public $isConfirmModalOpen = false;
    public ?User $selectedUserForVerification = null;
    public $isRejectModalOpen = false;
    public ?User $selectedUserForRejection = null;

    public function mount()
    {
        // Contoh data statis yang tidak berubah-ubah saat ngetik search
        $this->pageTitle = 'Verifikasi Anggota Baru';
    }

    public function fetchPendingUsers()
    {
        return User::query()
            ->withoutRole('anggota')
            ->where('status', 'pending')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function verifyUser($userId)
    {
        $user = $this->selectedUserForVerification;
        $user->update(['status' => 'active']);
        $user->assignRole('anggota');
        $user->save();

        session()->flash('success', 'User berhasil diverifikasi.');
    }

    // Method untuk membuka modal konfirmasi
    public function confirmVerification(User $user)
    {
        $this->selectedUserForVerification = $user;
        $this->isConfirmModalOpen = true;
    }

    public function executeVerification()
    {
        if ($this->selectedUserForVerification) {

            $this->verifyUser($this->selectedUserForVerification);

            // Reset kembali state modal
            $this->isConfirmModalOpen = false;
            $this->selectedUserForVerification = null;
        }
    }
    //confirm modal END


    // Method untuk menolak verifikasi
    public function confirmRejection(User $user)
    {
        $this->selectedUserForRejection = $user;
        $this->isRejectModalOpen = true;
    }

    public function executeRejection()
    {
        if ($this->selectedUserForRejection) {

            
            $this->selectedUserForRejection->update([
                'status' => 'rejected'
            ]);
            
            $this->dispatch('swal:success', [
                'title' => 'Pendaftaran Ditolak',
                'text' => "Akun {$this->selectedUserForRejection->name} telah ditolak."
            ]);
            
            $this->isRejectModalOpen = false;
            $this->selectedUserForRejection = null;
        }
    }



    public function render()
    {
        return view('livewire.admin.verifikasi-anggota', [
            'users' => $this->fetchPendingUsers()
        ]);
    }
}
