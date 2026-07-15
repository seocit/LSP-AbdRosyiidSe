<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat roles: hanya admin dan anggota
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $anggotaRole = Role::firstOrCreate(['name' => 'anggota', 'guard_name' => 'web']);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@perpustakaan.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'phone_number' => '08111000001',
            ]
        );
        $admin->syncRoles([$adminRole]);

        // Anggota 1 - aktif
        $member1 = User::firstOrCreate(
            ['email' => 'budi@member.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'phone_number' => '08122000001',
            ]
        );
        $member1->syncRoles([$anggotaRole]);

        // Anggota 2 - aktif
        $member2 = User::firstOrCreate(
            ['email' => 'sari@member.com'],
            [
                'name' => 'Sari Dewi',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'phone_number' => '08122000002',
            ]
        );
        $member2->syncRoles([$anggotaRole]);

        // Anggota 3 - aktif
        $member3 = User::firstOrCreate(
            ['email' => 'andi@member.com'],
            [
                'name' => 'Andi Pratama',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'phone_number' => '08122000003',
            ]
        );
        $member3->syncRoles([$anggotaRole]);

        // Anggota pending - belum diaktifkan admin
        $memberPending = User::firstOrCreate(
            ['email' => 'rizky@member.com'],
            [
                'name' => 'Rizky Firmansyah',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'pending',
                'phone_number' => '08122000004',
            ]
        );
        $memberPending->syncRoles([$anggotaRole]);
    }
}
