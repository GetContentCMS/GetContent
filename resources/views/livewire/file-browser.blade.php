<div
    x-data
    x-init="$focus.within($refs.fileList).first()"
    @keydown.right="$focus.wrap().next()"
    @keydown.left="$focus.wrap().previous()"
    @keydown.down="$focus.wrap().next()"
    @keydown.up="$focus.wrap().previous()"
>
    <x-gc::app.header>
        @if($teleportNav)
            {{-- @todo Teleport is not currently supported in Livewire, waiting for support --}}
            <template x-teleport="{{$teleportNav}}">
                @endif
                <nav class="flex items-center space-x-2 text-lg">
                    <x-gc::button flat wire:click="open('/', 'directory')">
                        <x-slot name="icon"><x-heroicon-o-folder-open /></x-slot>
                        Files
                    </x-gc::button>
                    @foreach($this->pathBreadcrumbs() as $item)
                        <div class="@if(!$loop->last) hidden sm:contents @else contents @endif">
                            <x-heroicon-o-chevron-right class="flex-shrink-0 mx-2 w-5 h-5 text-gray-600"
                                                        aria-hidden="true"/>
                            <x-gc::button flat wire:click="open('{{$item->path}}', 'directory')"
                                    title="Go back to {{$item->name}}">
                                @if ($loop->last) <span class="sm:hidden">&hellip;</span> @endif
                                <span class="hidden truncate sm:flex">{{$item->name}}</span>
                            </x-gc::button>
                        </div>
                    @endforeach
                </nav>
                @if($teleportNav)
            </template>
        @endif
    </x-gc::app.header>

    <x-gc::app.main class="bg-transparent">
        <div class="grid grid-cols-4 gap-3" x-ref="fileList">
            @foreach($files->forPage($currentPage, $perPage) as $file)
                @php($file = (object) $file)
                <button wire:click="open('{{$file->filename}}', '{{$file->mimeType}}')"
                        class="rounded-lg cursor-pointer focus-outline">
                    <x-gc::file-card :file="$file" />
                </button>
            @endforeach
        </div>

        <div class="flex justify-between items-center p-3 dark:text-gray-400">
            <x-gc::button wire:click="previousPage" :disabled="$currentPage === 1">Back</x-gc::button>
            <div>{{$currentPage}} / {{$this->totalPages}}</div>
            <x-gc::button wire:click="nextPage" :disabled="$currentPage === $this->totalPages">More</x-gc::button>
        </div>
    </x-gc::app.main>
</div>
