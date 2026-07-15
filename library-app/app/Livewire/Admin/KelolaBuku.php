<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Kelola Buku')]
class KelolaBuku extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = '';

    // Modal state
    public bool $isFormModalOpen = false;
    public bool $isDeleteModalOpen = false;
    public bool $isEdit = false;

    // Form fields
    public ?int $bookId = null;
    public string $title = '';
    public string $author = '';
    public string $publisher = '';
    public string $publish_year = '';
    public string $isbn = '';
    public int $category_id = 0;
    public int $stock = 0;
    public string $description = '';
    
    public $cover = null;
    public ?string $oldCover = null;
    
    // Delete target
    public ?Book $bookToDelete = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetValidation();
        $this->reset([
            'bookId', 'title', 'author', 'publisher', 'publish_year', 
            'isbn', 'category_id', 'stock', 'description', 'cover', 'oldCover'
        ]);
        
        $this->isEdit = false;
        $this->isFormModalOpen = true;
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $book = Book::findOrFail($id);
        
        $this->bookId = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->publisher = $book->publisher;
        $this->publish_year = $book->publish_year;
        $this->isbn = $book->isbn ?? '';
        $this->category_id = $book->category_id;
        $this->stock = $book->stock;
        $this->description = $book->description ?? '';
        
        $this->oldCover = $book->cover;
        $this->cover = null;
        
        $this->isEdit = true;
        $this->isFormModalOpen = true;
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publish_year' => 'required|string|max:4',
            'isbn' => 'nullable|string|max:50',
            'category_id' => 'required|exists:book_categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'publish_year' => $this->publish_year,
            'isbn' => $this->isbn,
            'category_id' => $this->category_id,
            'stock' => $this->stock,
            'description' => $this->description,
        ];

        if ($this->cover) {
            $data['cover'] = $this->cover->store('books/covers', 'public');
            
            if ($this->isEdit && $this->oldCover) {
                Storage::disk('public')->delete($this->oldCover);
            }
        }

        if ($this->isEdit) {
            Book::where('id', $this->bookId)->update($data);
            $message = 'Buku berhasil diupdate.';
        } else {
            Book::create($data);
            $message = 'Buku berhasil ditambahkan.';
        }

        $this->isFormModalOpen = false;
        
        $this->dispatch('swal:success', [
            'title' => 'Berhasil',
            'text' => $message,
        ]);
    }

    public function confirmDelete(int $id): void
    {
        $this->bookToDelete = Book::findOrFail($id);
        $this->isDeleteModalOpen = true;
    }

    public function executeDelete(): void
    {
        if ($this->bookToDelete) {
            if ($this->bookToDelete->cover) {
                Storage::disk('public')->delete($this->bookToDelete->cover);
            }
            
            $this->bookToDelete->delete();
            
            $this->isDeleteModalOpen = false;
            $this->bookToDelete = null;

            $this->dispatch('swal:success', [
                'title' => 'Berhasil',
                'text' => 'Buku telah dihapus.',
            ]);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $books = Book::with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                      ->orWhere('author', 'like', "%{$this->search}%")
                      ->orWhere('isbn', 'like', "%{$this->search}%");
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->latest()
            ->paginate(10);
            
        $categories = BookCategory::orderBy('name')->get();

        return view('livewire.admin.kelola-buku', [
            'books' => $books,
            'categories' => $categories,
        ]);
    }
}
