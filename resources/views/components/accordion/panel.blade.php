@props([
    'id' => Str::uuid(),
    'label' => null,
    'open' => false
])
<div class="text-gray-900 dark:text-gray-100"
     wire:ignore
     @if($open)x-init="openPanel('{{$id}}')"@endif
>
    <header>
        @if($label)
            <button @class([
                'flex items-center p-1 w-full font-semibold cursor-pointer',
                'bg-gray-200',
                'ring-blue-500 ring-opacity-25 outline-none focus:ring focus:border-blue-500',

                'dark:bg-gray-700',
                'dark:ring-opacity-50 dark:focus:border-blue-500 dark:active:bg-gray-600',
                ])
                    @click="togglePanel('{{$id}}')">
                <x-heroicon-o-chevron-right class="mr-1 w-4 h-4 opacity-50 transition"
                                            ::class="{'transform rotate-90': isOpen('{{$id}}')}"/>
                <div>{{$label}}</div>
            </button>
        @elseif($button)
            <div @click="togglePanel('{{$id}}')" {{$button->attributes}}>{{$button}}</div>
        @endif
    </header>

    <div x-show="isOpen('{{$id}}')" x-collapse x-cloak>
        <div {{$attributes->class(['p-2'])}}>
            {{$slot}}
        </div>
    </div>
</div>
