<div>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-ink">Dashboard Overview</h1>
        <p class="text-zinc-500 mt-1">Ringkasan aktivitas dan status perpustakaan saat ini.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Books -->
        <div class="bg-white rounded-2xl p-6 border border-zinc-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500 uppercase tracking-wider">Total Buku</p>
                <p class="text-3xl font-bold text-maroon mt-2">{{ number_format($totalBooks) }}</p>
            </div>
            <div class="p-3 bg-maroon/10 rounded-xl text-maroon">
                <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <!-- Total Members -->
        <div class="bg-white rounded-2xl p-6 border border-zinc-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500 uppercase tracking-wider">Total Anggota</p>
                <p class="text-3xl font-bold text-maroon mt-2">{{ number_format($totalMembers) }}</p>
            </div>
            <div class="p-3 bg-maroon/10 rounded-xl text-maroon">
                <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Active Loans -->
        <div class="bg-white rounded-2xl p-6 border border-zinc-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500 uppercase tracking-wider">Peminjaman Aktif</p>
                <p class="text-3xl font-bold text-brass mt-2">{{ number_format($activeLoansCount) }}</p>
            </div>
            <div class="p-3 bg-brass/10 rounded-xl text-brass">
                <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Overdue -->
        <div class="bg-white rounded-2xl p-6 border border-zinc-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-zinc-500 uppercase tracking-wider">Keterlambatan</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ number_format($overdueLoansCount) }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-xl text-red-600">
                <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Access Menu -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-ink mb-4">Akses Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @if($pendingReservationsCount > 0)
            <a href="{{ route('admin.verifikasi-reservasi') }}" class="flex flex-col items-center justify-center p-4 bg-maroon text-paper rounded-2xl hover:bg-maroon/90 transition shadow-sm text-center" wire:navigate>
                <div class="relative">
                    <svg class="size-7 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span class="absolute -top-2 -right-3 flex h-5 w-5 items-center justify-center rounded-full bg-brass text-[10px] font-bold text-ink">{{ $pendingReservationsCount }}</span>
                </div>
                <span class="text-sm font-semibold">Verifikasi Reservasi</span>
            </a>
            @else
            <a href="{{ route('admin.verifikasi-reservasi') }}" class="flex flex-col items-center justify-center p-4 bg-white text-zinc-700 border border-zinc-200 rounded-2xl hover:bg-zinc-50 transition shadow-sm text-center" wire:navigate>
                <svg class="size-7 mb-2 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span class="text-sm font-semibold">Verifikasi Reservasi</span>
            </a>
            @endif

            <a href="{{ route('admin.verifikasi-pengembalian') }}" class="flex flex-col items-center justify-center p-4 bg-white text-zinc-700 border border-zinc-200 rounded-2xl hover:bg-zinc-50 transition shadow-sm text-center" wire:navigate>
                <svg class="size-7 mb-2 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                <span class="text-sm font-semibold">Pengembalian Buku</span>
            </a>

            <a href="{{ route('admin.buku') }}" class="flex flex-col items-center justify-center p-4 bg-white text-zinc-700 border border-zinc-200 rounded-2xl hover:bg-zinc-50 transition shadow-sm text-center" wire:navigate>
                <svg class="size-7 mb-2 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-sm font-semibold">Kelola Buku</span>
            </a>

            <a href="{{ route('admin.kelola-anggota') }}" class="flex flex-col items-center justify-center p-4 bg-white text-zinc-700 border border-zinc-200 rounded-2xl hover:bg-zinc-50 transition shadow-sm text-center" wire:navigate>
                <svg class="size-7 mb-2 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-sm font-semibold">Kelola Anggota</span>
            </a>
            
            <a href="{{ route('admin.pengumuman') }}" class="flex flex-col items-center justify-center p-4 bg-white text-zinc-700 border border-zinc-200 rounded-2xl hover:bg-zinc-50 transition shadow-sm text-center" wire:navigate>
                <svg class="size-7 mb-2 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <span class="text-sm font-semibold">Buat Pengumuman</span>
            </a>

            <a href="{{ route('admin.konfigurasi') }}" class="flex flex-col items-center justify-center p-4 bg-white text-zinc-700 border border-zinc-200 rounded-2xl hover:bg-zinc-50 transition shadow-sm text-center" wire:navigate>
                <svg class="size-7 mb-2 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-sm font-semibold">Konfigurasi</span>
            </a>
        </div>
    </div>

    <!-- Active Loans and Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Active Loans (Terima Pengembalian) -->
        <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col max-h-[500px]">
            <div class="p-5 border-b border-zinc-100 bg-zinc-50 flex items-center justify-between">
                <h2 class="text-lg font-bold text-ink flex items-center gap-2">
                    <svg class="size-5 text-brass" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Peminjaman Aktif
                </h2>
                <span class="text-xs font-semibold px-2.5 py-1 bg-brass/10 text-brass rounded-full">{{ $activeLoansCount }} Buku</span>
            </div>
            <div class="p-0 flex-1 overflow-auto custom-scrollbar">
                @if($activeLoans->isNotEmpty())
                    <ul class="divide-y divide-zinc-100">
                        @foreach($activeLoans as $loan)
                            <li class="p-4 hover:bg-zinc-50 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-sm text-ink">{{ $loan->book->title ?? 'Buku Tidak Ditemukan' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-medium text-zinc-600 bg-zinc-100 px-2 py-0.5 rounded">{{ $loan->user->name ?? 'Anonim' }}</span>
                                        <span class="text-[10px] uppercase font-bold tracking-wider text-zinc-400">{{ $loan->reservation_code }}</span>
                                    </div>
                                </div>
                                <div>
                                    <button 
                                        wire:click="returnBook({{ $loan->id }})"
                                        wire:confirm="Konfirmasi: Apakah buku ini telah dikembalikan oleh anggota?"
                                        class="inline-flex w-full justify-center sm:w-auto items-center gap-1.5 px-3 py-2 text-xs font-semibold bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg transition"
                                    >
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Terima
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full py-10 text-zinc-400">
                        <svg class="size-10 mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm">Tidak ada peminjaman aktif saat ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col max-h-[500px]">
            <div class="p-5 border-b border-zinc-100 bg-zinc-50">
                <h2 class="text-lg font-bold text-ink flex items-center gap-2">
                    <svg class="size-5 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aktivitas Terkini
                </h2>
            </div>
            <div class="p-0 flex-1 overflow-auto custom-scrollbar">
                @if($recentActivities->isNotEmpty())
                    <ul class="divide-y divide-zinc-100">
                        @foreach($recentActivities as $activity)
                            <li class="p-4 hover:bg-zinc-50 transition flex items-start gap-3">
                                <div class="p-2 rounded-full mt-0.5 shrink-0
                                    @if($activity->status == 'pending') bg-yellow-100 text-yellow-600
                                    @elseif($activity->status == 'approved') bg-brass/20 text-brass
                                    @elseif($activity->status == 'rejected') bg-red-100 text-red-600
                                    @elseif($activity->status == 'returned') bg-emerald-100 text-emerald-600
                                    @else bg-zinc-100 text-zinc-600 @endif
                                ">
                                    @if($activity->status == 'pending')
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($activity->status == 'approved')
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($activity->status == 'returned')
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-ink truncate">
                                        {{ $activity->user->name ?? 'User' }}
                                        <span class="font-normal text-zinc-500">
                                            @if($activity->status == 'pending') mereservasi
                                            @elseif($activity->status == 'approved') meminjam
                                            @elseif($activity->status == 'rejected') ditolak meminjam
                                            @elseif($activity->status == 'returned') mengembalikan
                                            @else memperbarui @endif
                                        </span>
                                        {{ $activity->book->title ?? 'Buku' }}
                                    </p>
                                    <p class="text-xs text-zinc-400 mt-0.5">{{ $activity->updated_at->diffForHumans() }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full py-10 text-zinc-400">
                        <svg class="size-10 mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm">Belum ada aktivitas tercatat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
