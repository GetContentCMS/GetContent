<div>
    <x-gc::section-heading class="mt-6">
        Repeater Template
    </x-gc::section-heading>

    <div class="flex justify-end my-1">
        <x-gc::popover boundary="#fieldSettings" placement="top-end">
            <x-slot name="trigger">
                <x-gc::button flat>
                    <x-slot name="icon">
                        <x-heroicon-o-plus class="text-gray-500"/>
                    </x-slot>
                    Add field
                </x-gc::button>
            </x-slot>

            @foreach($GetContent->getAvailableFields()->except('repeater') as $type => $fieldClass)
                <x-gc::menu.item
                    wire:click="callFieldMethod('{{$this->configureField->modelKey}}', 'addField', '{{$type}}')">
                    <x-slot name="icon">
                        <x-dynamic-component :component="($fieldClass)::getIcon()"/>
                    </x-slot>
                    {{($fieldClass)::getName()}}
                </x-gc::menu.item>
            @endforeach
        </x-gc::popover>
    </div>

    <div class="space-y-1">
        @foreach($this->configureField->template as $definition)
            <div class="flex items-center p-3 space-x-1 bg-gray-800 rounded border border-gray-700 shadow-lg">
                <div>
                    {{$definition['type']}}
                    {{$definition['modelKey']}}
                </div>
                <x-gc::input wire:model="schema.{{$this->configureField->modelKey}}.template.{{$loop->index}}.modelKey" class="flex-grow" />
                <x-gc::button wire:click="callFieldMethod('{{$this->configureField->modelKey}}', 'removeField', '{{$loop->index}}')">
                    <x-slot name="icon"><x-heroicon-o-x/></x-slot>
                </x-gc::button>
            </div>
        @endforeach
    </div>

</div>
