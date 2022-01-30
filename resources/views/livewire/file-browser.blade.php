<div
    x-init="$focus.within($el).first()"
    @keydown.right="$focus.wrap().next()"
    @keydown.left="$focus.wrap().previous()"
    @keydown.down="$focus.wrap().next()"
    @keydown.up="$focus.wrap().previous()"
>
    <div class="grid grid-cols-3 gap-3">
        @foreach($files->forPage($currentPage, $perPage) as $file)
            <x-gc::card compact tabindex="-1"
                        class="cursor-pointer focus:outline hover:outline outline-1 outline-blue-500"
                        @click="$dispatch('choose', '{{$file['filename']}}')"
            >
                @if(Str::startsWith($file['mimeType'], 'image/'))
                    <img src="{{$file['url']}}" class="object-contain mx-auto max-h-32 rounded-md"/>
                @else
                    <div class="p-8 mx-auto w-32 h-32 text-gray-400 bg-gray-200 rounded">
                    @if(Str::endsWith($file['mimeType'], 'zip'))
                        <x-ri-file-zip-line />
                    @elseif(Str::endsWith($file['mimeType'], 'pdf'))
                        <x-ri-file-text-line />
                    @elseif($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                        <x-ri-file-word-2-line />
                    @elseif($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                        <x-ri-file-excel-2-line />
                    @elseif($file['mimeType'] === 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                        <x-ri-file-ppt-2-line />
                    @else
                        <x-ri-file-3-line />
                    @endif
                    </div>
                @endif
                <x-slot name="footer" class="text-sm truncate">
                    {{$file['filename']}}
                </x-slot>
            </x-gc::card>
        @endforeach
    </div>
    <div class="flex justify-between items-center p-3">
        <x-gc::button wire:click="previousPage" :disabled="$currentPage === 1">Back</x-gc::button>
        <div>{{$currentPage}} / {{$this->totalPages}}</div>
        <x-gc::button wire:click="nextPage" :disabled="$currentPage === $this->totalPages">More</x-gc::button>
    </div>
</div>
