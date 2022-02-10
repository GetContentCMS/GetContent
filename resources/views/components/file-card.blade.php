<x-gc::card compact>
    @if($file->mimeType === 'directory')
        <div class="p-8 mx-auto w-32 h-32 text-gray-600">
            <x-ri-folder-5-fill/>
        </div>
    @elseif(Str::startsWith($file->mimeType, 'image/'))
        <img src="{{$file->url}}" class="object-contain mx-auto max-h-32 rounded-md"/>
    @else
        <div class="p-8 mx-auto w-32 h-32 text-gray-400 bg-gray-200 rounded">
            @if(Str::endsWith($file->mimeType, 'zip'))
                <x-ri-file-zip-line/>
            @elseif(Str::endsWith($file->mimeType, 'pdf'))
                <x-ri-file-text-line/>
            @elseif($file->mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                <x-ri-file-word-2-line/>
            @elseif($file->mimeType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                <x-ri-file-excel-2-line/>
            @elseif($file->mimeType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation')
                <x-ri-file-ppt-2-line/>
            @else
                <x-ri-file-3-line/>
            @endif
        </div>
    @endif
    <x-slot name="footer" class="flex justify-between items-center space-x-2">
        <div class="text-sm truncate">{{$file->name}}</div>
        {{$controls ?? null}}
    </x-slot>
</x-gc::card>
