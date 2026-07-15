<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Reservation;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.member')]
#[Title('Katalog Buku')]
class PeminjamanBuku extends Component
{
    use WithPagination;

    #[Url(as: 'cari')]
    public string $search = '';

    #[Url(as: 'kategori')]
    public string $categoryFilter = '';

    #[Url(as: 'tahun')]
    public string $yearFilter = '';

    /** @var array<int, array<string, mixed>> */
    public array $cart = [];

    public bool $isSubmitting = false;

    public function mount(): void
    {
        if (Auth::check() && Auth::user()->status === 'inactive') {
            abort(403, 'Akun Anda telah dinonaktifkan. Anda tidak dapat mengakses fitur peminjaman.');
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatedYearFilter(): void
    {
        $this->resetPage();
    }

    public function addToCart(int $bookId): void
    {
        $maxBooks = (int) SystemSetting::getSetting('max_books_per_loan', 3);

        if (count($this->cart) >= $maxBooks) {
            $this->dispatch('notify', ['type' => 'error', 'message' => "Maksimum {$maxBooks} buku per reservasi."]);

            return;
        }

        if (isset($this->cart[$bookId])) {
            $this->dispatch('notify', ['type' => 'warning', 'message' => 'Buku sudah ada di keranjang.']);

            return;
        }

        $book = Book::find($bookId);
        if (! $book || ! $book->isAvailable()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Buku tidak tersedia.']);

            return;
        }

        $this->cart[$bookId] = [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'cover' => $book->cover,
            'stock' => $book->stock,
        ];

        $this->dispatch('notify', ['type' => 'success', 'message' => "\"{$book->title}\" ditambahkan ke keranjang."]);
    }

    public function removeFromCart(int $bookId): void
    {
        unset($this->cart[$bookId]);
    }

    public function submitReservation(): void
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Keranjang kosong.']);

            return;
        }

        $user = Auth::user();
        $today = now()->toDateString();

        foreach ($this->cart as $bookId => $item) {
            $book = Book::find($bookId);
            if (! $book || ! $book->isAvailable()) {
                continue;
            }

            Reservation::create([
                'reservation_code' => Reservation::generateCode(),
                'user_id' => $user->id,
                'book_id' => $book->id,
                'reservation_date' => $today,
                'status' => 'pending',
            ]);
        }

        $this->cart = [];
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Reservasi berhasil dikirim. Menunggu konfirmasi admin.']);
    }

    public function render(): \Illuminate\View\View
    {
        $books = Book::query()
            ->with('category')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('author', 'like', "%{$this->search}%")
                ->orWhere('isbn', 'like', "%{$this->search}%"))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->yearFilter, fn ($q) => $q->where('publish_year', $this->yearFilter))
            ->latest()
            ->paginate(12);

        $categories = BookCategory::orderBy('name')->get();

        $years = Book::selectRaw('DISTINCT publish_year')
            ->orderByDesc('publish_year')
            ->pluck('publish_year');

        $maxBooks = (int) SystemSetting::getSetting('max_books_per_loan', 3);

        return view('livewire.member.peminjaman-buku', [
            'books' => $books,
            'categories' => $categories,
            'years' => $years,
            'maxBooks' => $maxBooks,
        ]);
    }
}
