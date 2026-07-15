<?php

namespace App\Livewire\Admin;

use App\Models\SystemSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Konfigurasi Sistem')]
class Konfigurasi extends Component
{
    // Settings state
    public $settings = [];

    public function mount(): void
    {
        $allSettings = SystemSetting::all();
        
        foreach ($allSettings as $setting) {
            $this->settings[$setting->key] = $setting->value;
        }
    }

    public function saveSettings(): void
    {
        $rules = [
            'settings.loan_fee' => 'required|numeric|min:0',
            'settings.fine_per_day' => 'required|numeric|min:0',
            'settings.max_books_per_loan' => 'required|integer|min:1',
            'settings.loan_duration_days' => 'required|integer|min:1',
            'settings.bank_name' => 'nullable|string|max:100',
            'settings.bank_account_number' => 'nullable|string|max:50',
            'settings.bank_account_name' => 'nullable|string|max:100',
            'settings.library_name' => 'required|string|max:255',
            'settings.library_address' => 'nullable|string',
            'settings.library_phone' => 'nullable|string|max:20',
        ];

        $this->validate($rules);

        foreach ($this->settings as $key => $value) {
            SystemSetting::setSetting($key, $value);
        }

        $this->dispatch('swal:success', [
            'title' => 'Berhasil Disimpan',
            'text' => 'Konfigurasi sistem berhasil diperbarui.',
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.konfigurasi');
    }
}
