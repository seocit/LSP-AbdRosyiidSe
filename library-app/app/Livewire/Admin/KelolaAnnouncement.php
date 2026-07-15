<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Kelola Pengumuman')]
class KelolaAnnouncement extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';
    
    // Modal state
    public bool $isFormModalOpen = false;
    public bool $isDeleteModalOpen = false;
    public bool $isEdit = false;

    // Form fields
    public ?int $announcementId = null;
    public string $title = '';
    public string $content = '';
    public $image = null;
    public ?string $oldImage = null;
    
    // Delete target
    public ?Announcement $announcementToDelete = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetValidation();
        $this->reset(['announcementId', 'title', 'content', 'image', 'oldImage']);
        $this->isEdit = false;
        $this->isFormModalOpen = true;
        $this->dispatch('init-quill', content: '');
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $announcement = Announcement::findOrFail($id);
        
        $this->announcementId = $announcement->id;
        $this->title = $announcement->title;
        $this->content = $announcement->content ?? '';
        $this->oldImage = $announcement->image;
        $this->image = null;
        
        $this->isEdit = true;
        $this->isFormModalOpen = true;
        
        $this->dispatch('init-quill', content: $this->content);
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'created_by' => Auth::id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('announcements', 'public');
            
            // Delete old image if exists and editing
            if ($this->isEdit && $this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
        }

        if ($this->isEdit) {
            Announcement::where('id', $this->announcementId)->update($data);
            $message = 'Pengumuman berhasil diupdate.';
        } else {
            Announcement::create($data);
            $message = 'Pengumuman berhasil ditambahkan.';
        }

        $this->isFormModalOpen = false;
        
        $this->dispatch('swal:success', [
            'title' => 'Berhasil',
            'text' => $message,
        ]);
    }

    public function confirmDelete(int $id): void
    {
        $this->announcementToDelete = Announcement::findOrFail($id);
        $this->isDeleteModalOpen = true;
    }

    public function executeDelete(): void
    {
        if ($this->announcementToDelete) {
            if ($this->announcementToDelete->image) {
                Storage::disk('public')->delete($this->announcementToDelete->image);
            }
            
            $this->announcementToDelete->delete();
            
            $this->isDeleteModalOpen = false;
            $this->announcementToDelete = null;

            $this->dispatch('swal:success', [
                'title' => 'Berhasil',
                'text' => 'Pengumuman telah dihapus.',
            ]);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $announcements = Announcement::with('creator')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                      ->orWhere('content', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.kelola-announcement', [
            'announcements' => $announcements,
        ]);
    }
}
