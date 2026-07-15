<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\Book;
use App\Models\BookCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.member')]
class Welcome extends Component
{
    #[Url(as: 'cari')]
    public string $search = '';

    #[Url(as: 'kategori')]
    public string $categoryFilter = '';

    public function render(): \Illuminate\View\View
    {
        $books = Book::query()
            ->with('category')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('author', 'like', "%{$this->search}%"))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $announcements = Announcement::latest()->take(3)->get();
        $categories = BookCategory::all();

        return view('welcome', [
            'books' => $books,
            'announcements' => $announcements,
            'categories' => $categories,
        ]);
    }
}
