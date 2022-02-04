@aware([
    'leadingIcon' => null,
    'trailingIcon' => null,
])
@props([
    'id',
    'label' => null,
    'help' => null,
    'error' => null,
])

<div {{$attributes->class([])}}>
    @if($label)
        <label for="{{$id}}" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">{{$label}}</label>
    @endif
    <div class="relative">
        @if($leadingIcon)
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <x-dynamic-component :component="$leadingIcon" class="w-5 h-5 text-gray-400"/>
            </div>
        @endif

        {{$slot}}

        @if($trailingIcon)
            <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                <x-dynamic-component :component="$trailingIcon" class="w-5 h-5 text-gray-400"/>
            </div>
        @endif
    </div>
    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400" id="{{$id}}-description">{{$error}}</p>
    @elseif($help)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" id="{{$id}}-description">{{$help}}</p>
    @endif
</div>
