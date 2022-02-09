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
    public ?string $path = null;
    public ?string $currentPath = null;
    public int $perPage = 12;
    public int $currentPage = 1;
    public ?string $teleportNav = null;

    public function mount(): void
    {
        $this->loadFiles($this->path, $this->accept);
    }

    public function loadFiles($path, $accept): void
    {
        $this->files = GetContent::getFiles($path, $accept)->map(fn ($file) => $file->info())->sortBy('updated_at');
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

    public function open($filename, $mimeType): void
    {
        if ($mimeType === 'directory') {
            $this->loadFiles($filename, $this->accept);
            $this->currentPath = $filename;
            $this->emit('fileBrowser-currentPath', $filename);

            return;
        }

        $this->dispatchBrowserEvent('choose', $filename);
    }

    public function pathBreadcrumbs(): \Illuminate\Support\Collection
    {
        $path = '';

        return collect(explode('/', $this->currentPath))->map(function ($item) use (&$path) {
            $path .= "/{$item}";

            return (object) ['name' => $item, 'path' => $path];
        })->filter(fn ($item) => ! blank($item->name));
    }
}
