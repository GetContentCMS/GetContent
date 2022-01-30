@props([
    'x-model' => null,
    'flat' => false
])
<x-gc::button
    :attributes="$attributes->merge($xModel ? ['@click' => $xModel.' = !'.$xModel] : [])->merge(['flat' => $flat])"
    ::class="{
        'text-white bg-blue-500': {{$xModel}},
        'active:bg-blue-400 focus:bg-blue-500 hover:bg-blue-400': {{$xModel}},
        'dark:bg-blue-700 dark:active:bg-blue-600 dark:focus:bg-blue-700 dark:hover:bg-blue-600': {{$xModel}},
        'border-blue-300 dark:border-blue-500': {{$flat ? 'false' : 'true'}} && {{$xModel}}
    }">
    {{$slot}}
    <x-slot name="hidden">
        <input type="checkbox" x-model="{{$xModel}}" class="hidden" aria-hidden="true" />
    </x-slot>
</x-gc::button>
