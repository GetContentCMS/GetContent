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
            <template x-teleport="{{$teleportNav}}">
                @endif
                <nav class="flex items-center space-x-2 text-lg">
                    <button wire:click="open('/', 'directory')">
                        <x-heroicon-o-folder-open class="inline-block w-5 h-5"/>
                        Files
                    </button>
                    @foreach($this->pathBreadcrumbs() as $item)
                        <div class="@if(!$loop->last) hidden sm:contents @else contents @endif">
                            <x-heroicon-o-chevron-right class="flex-shrink-0 mx-2 w-5 h-5 text-gray-600"
                                                        aria-hidden="true"/>
                            <button wire:click="open('{{$item->path}}', 'directory')"
                                    title="Go back to {{$item->name}}">
                                @if ($loop->last) <span class="sm:hidden">&hellip;</span> @endif
                                <span class="hidden truncate sm:flex">{{$item->name}}</span>
                            </button>
                        </div>
                    @endforeach
                </nav>
                @if($teleportNav)
            </template>
        @endif
    </x-gc::app.header>
    <div class="grid grid-cols-3 gap-3" x-ref="fileList">
        @foreach($files->forPage($currentPage, $perPage) as $file)
            <x-gc::card compact tabindex="-1"
                        class="cursor-pointer focus:outline outline-1 outline-blue-500"
                        wire:click="open('{{$file['filename']}}', '{{$file['mimeType']}}')"
            >
                @if($file['mimeType'] === 'directory')
                    <div class="p-8 mx-auto w-32 h-32 text-gray-600">
                        <x-ri-folder-5-fill/>
                    </div>
                @elseif(Str::startsWith($file['mimeType'], 'image/'))
                    <img src="{{$file['url']}}" class="object-contain mx-auto max-h-32 rounded-md"/>
                @else
                    <div class="p-8 mx-auto w-32 h-32 text-gray-400 bg-gray-200 rounded">
                        @if(Str::endsWith($file['mimeType'], 'zip'))
                            <x-ri-file-zip-line/>
                        @elseif(Str::endsWith($file['mimeType'], 'pdf'))
                            <x-ri-file-text-line/>
                        @elseif($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                            <x-ri-file-word-2-line/>
                        @elseif($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                            <x-ri-file-excel-2-line/>
                        @elseif($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                            <x-ri-file-ppt-2-line/>
                        @else
                            <x-ri-file-3-line/>
                        @endif
                    </div>
                @endif
                <x-slot name="footer" class="text-sm truncate">
                    {{$file['name']}}
                </x-slot>
            </x-gc::card>
        @endforeach
    </div>
    <div class="flex justify-between items-center p-3 dark:text-gray-400">
        <x-gc::button wire:click="previousPage" :disabled="$currentPage === 1">Back</x-gc::button>
        <div>{{$currentPage}} / {{$this->totalPages}}</div>
        <x-gc::button wire:click="nextPage" :disabled="$currentPage === $this->totalPages">More</x-gc::button>
    </div>
</div>
