<?php

namespace GetContent\CMS\Http\Livewire;

use GetContent\CMS\Facades\GetContent;
use Livewire\Component;

/**
 * @property mixed $totalPages
 */
class FileBrowser extends Component
{
    public \Illuminate\Support\Collection $files;
    public ?string $accept = null;
    public int $perPage = 12;
    public int $currentPage = 1;

    public function mount(): void
    {
        $this->files = GetContent::getFiles($this->accept)->map(fn ($file) => $file->info());
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('gc::livewire.file-browser');
    }

    public function getTotalPagesProperty(): int
    {
        return (int) ceil(count($this->files) / $this->perPage);
    }

    public function nextPage(): void
    {
        if ($this->currentPage < $this->totalPages) {
            $this->currentPage++;
        }
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }
}
