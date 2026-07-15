<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.member')]
#[Title('Pengumuman')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'cari')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\View\View
    {
        $announcements = Announcement::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('content', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(9);

        return view('livewire.announcements.index', [
            'announcements' => $announcements,
        ]);
    }
}
