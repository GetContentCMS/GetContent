<x-gc::card compact class="bg-gray-50/60">

    @if($field->givenLabel)
        <x-slot name="header" class="flex text-sm text-gray-700 bg-gray-100/50">
            <x-dynamic-component :component="$field->getIcon()" class="mr-2 w-5 h-5"/>
            {{$field->givenLabel}}
        </x-slot>
    @endif

    <div class="p-2 space-y-2">
        @foreach($field->template->fields as $templateField)
            @php($templateField->setBaseModel($field->modelKey))
            {{$templateField->editorView->with([
                'field' => $templateField,
            ])}}
        @endforeach
    </div>
</x-gc::card>
