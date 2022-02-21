<div class="flex p-6 space-x-2">
    <x-gc::button flat element="a"
        href="{{route('document:browser', ['group' => $document->group?->uuid])}}">
        Close
    </x-gc::button>
    <x-gc::button primary flat class="flex-grow" wire:click="save" wire:loading.attr="disabled" wire:target="save">
        Save
    </x-gc::button>
</div>

<x-gc::accordion allow-multiple>
    <x-gc::accordion.panel label="Document" open class="space-y-4">
        <x-gc::input label="Document Slug" help="This is the unique URL for this document" class="text-xs"
                     wire:model="document.slug"/>

        <div class="flex items-end space-x-2">
            <x-gc::date label="Publish from" wire:model="document.published_at" class="flex-shrink-0 w-40" />
        </div>

        <dl class="my-3 text-xs text-gray-500">
            <dt class="font-bold">Document UUID</dt>
            <dd>{{$document->uuid}}</dd>
            <dt class="mt-1 font-bold">Created</dt>
            <dd>{{$document->created_at?->format('Y-m-d H:i')}}</dd>
        </dl>

        @if(!$document->usingGroupSchema)
        <x-gc::toggle-button x-model="sortFields" class="my-2">
            <x-slot name="icon"><x-heroicon-o-switch-vertical/></x-slot>
            Sort Fields
        </x-gc::toggle-button>
        @endif
    </x-gc::accordion.panel>

    @if(!$document->usingGroupSchema)
    <x-gc::accordion.panel label="Fields" open>
        <div class="grid grid-cols-2 gap-2">
            @foreach(GetContent::getAvailableFields() as $type => $field)
                <x-gc::button wire:click="addField('{{$type}}')" flat class="h-12">
                    <x-slot name="icon">
                        <x-dynamic-component :component="($field)::getIcon()"/>
                    </x-slot>
                    {{($field)::getName()}}
                </x-gc::button>
            @endforeach

            <x-gc::field-templates />
        </div>
    </x-gc::accordion.panel>
    @endif

</x-gc::accordion>
