<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Biaya Peminjaman
            [
                'key' => 'loan_fee',
                'value' => '0',
                'label' => 'Biaya Peminjaman per Buku (Rp)',
                'group' => 'loan',
                'type' => 'number',
            ],
            [
                'key' => 'fine_per_day',
                'value' => '0',
                'label' => 'Denda Keterlambatan per Hari (Rp)',
                'group' => 'loan',
                'type' => 'number',
            ],
            [
                'key' => 'max_books_per_loan',
                'value' => '3',
                'label' => 'Maksimum Buku per Reservasi',
                'group' => 'loan',
                'type' => 'number',
            ],
            [
                'key' => 'loan_duration_days',
                'value' => '7',
                'label' => 'Durasi Peminjaman (Hari)',
                'group' => 'loan',
                'type' => 'number',
            ],

            // Info Rekening Bank
            [
                'key' => 'bank_name',
                'value' => '',
                'label' => 'Nama Bank',
                'group' => 'payment',
                'type' => 'text',
            ],
            [
                'key' => 'bank_account_number',
                'value' => '',
                'label' => 'Nomor Rekening',
                'group' => 'payment',
                'type' => 'text',
            ],
            [
                'key' => 'bank_account_name',
                'value' => '',
                'label' => 'Nama Pemilik Rekening',
                'group' => 'payment',
                'type' => 'text',
            ],

            // Informasi Perpustakaan
            [
                'key' => 'library_name',
                'value' => 'Perpustakaan',
                'label' => 'Nama Perpustakaan',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'library_address',
                'value' => '',
                'label' => 'Alamat Perpustakaan',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'library_phone',
                'value' => '',
                'label' => 'Nomor Telepon Perpustakaan',
                'group' => 'general',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
