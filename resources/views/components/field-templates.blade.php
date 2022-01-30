@foreach(GetContent::getFieldTemplates() as $template)
    <x-gc::button wire:click="addField('template', {'template':  '{{$template->slug}}'})" flat class="h-12">
        <x-slot name="icon">
            <x-dynamic-component :component="$template->icon ?? 'heroicon-s-dots-horizontal'"/>
        </x-slot>
        {{$template->name}}
    </x-gc::button>
@endforeach
