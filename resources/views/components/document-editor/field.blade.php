@props([
    'configurable' => true,
    'field'
])
<div class="flex relative w-full" wire:key="field-{{$field->modelKey}}">

    <div class="w-full">
        {{$field->editorView->with(['field' => $field])}}
    </div>

    @if($configurable)
        <div class="-mr-3 ml-2">
            <x-gc::popover>
                <x-slot name="trigger">
                    <x-gc::button flat class="bg-gray-50 sm:py-1 sm:px-0">
                        <x-slot name="icon">
                            <x-heroicon-o-dots-vertical class="text-gray-500"/>
                        </x-slot>
                    </x-gc::button>
                </x-slot>
                <x-gc::menu.item
                    @click="$store.modals.fieldSettings = true"
                    wire:click="configureField('{{$field->modelKey}}')"
                >
                    <x-slot name="icon">
                        <x-heroicon-o-cog/>
                    </x-slot>
                    Field Settings
                </x-gc::menu.item>
                <x-gc::menu.divider/>
                <x-gc::menu.item wire:click="removeField('{{$field->modelKey}}')">
                    <x-slot name="icon">
                        <x-heroicon-o-trash/>
                    </x-slot>
                    Remove Field
                </x-gc::menu.item>
            </x-gc::popover>
        </div>
    @endif
</div>
