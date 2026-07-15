<?php

namespace App\Livewire\Member;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.member')]
#[Title('Profil Saya')]
class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $phoneNumber = '';

    public $avatar = null;

    public bool $isEditMode = false;

    public bool $isPasswordMode = false;

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public int $historyLimit = 10;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phoneNumber = $user->phone_number ?? '';
    }

    public function saveProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phoneNumber' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
        ];

        if ($this->avatar) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($data);

        $this->isEditMode = false;
        $this->avatar = null;
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Profil berhasil diperbarui.']);
    }

    public function savePassword(): void
    {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (! Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'Password saat ini tidak sesuai.');

            return;
        }

        $user->update(['password' => $this->newPassword]);

        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
        $this->isPasswordMode = false;
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Password berhasil diperbarui.']);
    }

    public function loadMoreHistory(): void
    {
        $this->historyLimit += 10;
    }

    public function render(): \Illuminate\View\View
    {
        $user = Auth::user();

        $history = Reservation::with(['book'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $totalBorrowed = $history->whereIn('status', ['approved', 'waiting_payment', 'completed'])->count();
        $currentlyBorrowed = $history->where('status', 'approved')->count();

        $displayHistory = $history->take($this->historyLimit);
        $hasMoreHistory = $history->count() > $this->historyLimit;

        return view('livewire.member.profile', [
            'user' => $user,
            'history' => $displayHistory,
            'totalBorrowed' => $totalBorrowed,
            'currentlyBorrowed' => $currentlyBorrowed,
            'hasMoreHistory' => $hasMoreHistory,
        ]);
    }
}
