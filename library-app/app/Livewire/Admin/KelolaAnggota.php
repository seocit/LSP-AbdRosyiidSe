<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Kelola Anggota')]
class KelolaAnggota extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $isConfirmModalOpen = false;
    public ?User $selectedUser = null;
    public string $newStatus = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmStatusChange(int $userId, string $status): void
    {
        $this->selectedUser = User::find($userId);
        $this->newStatus = $status;
        $this->isConfirmModalOpen = true;
    }

    public function executeStatusChange(): void
    {
        if ($this->selectedUser) {
            $this->selectedUser->update([
                'status' => $this->newStatus
            ]);

            $this->dispatch('swal:success', [
                'title' => 'Status Berhasil Diubah',
                'text' => "Status {$this->selectedUser->name} telah diubah menjadi {$this->newStatus}."
            ]);

            $this->isConfirmModalOpen = false;
            $this->selectedUser = null;
        }
    }

    public function render(): \Illuminate\View\View
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.kelola-anggota', [
            'users' => $users
        ]);
    }
}
