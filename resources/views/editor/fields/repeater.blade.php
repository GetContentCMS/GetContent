<div>
    <p class="mb-1">{{$field->label}}</p>
    @if(blank($field->template))
        <x-gc::button @click="$store.modals.fieldSettings = true"
                      wire:click="configureField('{{$field->modelKey}}')"
        >Set up {{$field->label}}</x-gc::button>
    @endif

    <div class="grid grid-cols-6 gap-2">

        @foreach(Arr::get($field->model, 'items', []) as $instance)
            @php($itemIndex = $loop->index)
            <div class="flex relative flex-col col-span-3 justify-end items-center p-3 space-y-1 rounded bg-gray-200/50 group"
                 wire:key="{{$field->modelKey.".items.{$itemIndex}"}}">
                @foreach($field->template->fields as $templateField)
                    @php($templateField->setBaseModel($field->modelKey.".items.{$itemIndex}"))
                    {{$templateField->editorView->with([
                        'field' => $templateField,
                        ])}}
                @endforeach

                <div class="flex hidden absolute -right-1 -top-3 p-1 bg-white rounded border shadow scale-90 group-hover:flex">
{{--
                    <x-gc::button flat class="cursor-move">
                        <x-slot name="icon"><x-ri-drag-move-fill/></x-slot>
                    </x-gc::button>
--}}
                    <x-gc::button flat
                                  wire:click="callFieldMethod('{{$field->modelKey}}', 'removeField', {{$itemIndex}})">
                        <x-slot name="icon"><x-heroicon-o-x/></x-slot>
                    </x-gc::button>
                </div>
            </div>
        @endforeach

        <button wire:click="callFieldMethod('{{$field->modelKey}}', 'addField')"
                class="flex col-span-3 justify-center items-center p-3 text-lg font-semibold text-gray-400 rounded-md border-2 border border-dashed cursor-pointer focus:text-blue-500 focus-outline hover:border-blue-500 hover:text-blue-500">
            <x-heroicon-o-plus class="w-6"/>
            Add New Item
        </button>
    </div>
</div>
