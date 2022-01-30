@foreach($document->fields as $field)
    <div wire:sortable.item="{{ $field->modelKey }}">
        <div class="flex items-center p-2 mb-6 space-x-2 bg-white rounded-md shadow">
            <x-heroicon-o-dots-vertical class="h-6 text-gray-500"/>
            <div class="p-2 w-8 h-8 text-blue-200 bg-blue-500 rounded-full">
                <x-dynamic-component :component="$field->getIcon()"/>
            </div>
            <div>
                {{$field->label}}
            </div>
            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                {{$field->modelKey}}
            </div>
        </div>
    </div>
@endforeach
