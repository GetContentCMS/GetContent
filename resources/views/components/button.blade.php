@aware([
    'icon' => null
])
@props([
    'element' => 'button',
    'flat' => false,
    'primary' => false,
])
<{{$element}} {{$attributes->class([
    'px-2 py-1 rounded flex items-center justify-center',
    'focus-outline',

    'text-gray-900 active:bg-gray-50',
    'bg-white border shadow-sm' => !$flat,
    'bg-transparent hover:bg-gray-200 focus:bg-gray-200' => $flat,
    'bg-gradient-to-b from-blue-500 to-blue-600 text-white border-blue-600 font-medium' => $primary,
    'active:from-blue-600' => $primary,

    'disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none',

    'dark:text-gray-100',
    'dark:border-gray-600 dark:bg-gray-700' => !$flat,
    'dark:border-blue-600' => $primary,
    'dark:active:bg-gray-600',
    'dark:hover:bg-gray-700 dark:focus:bg-gray-700' => $flat,
    ])->merge()}}>
    @isset($icon)
        <div @class([
            'w-5 h-5 opacity-80',
            'mr-2' => $slot->isNotEmpty()
        ])>
            {{$icon}}
        </div>
    @endisset
    <div class="truncate">
        {{$slot->isEmpty() && !isset($icon) ? 'Button' : $slot}}
    </div>
    @isset($hidden)
        <div class="hidden">{{$hidden}}</div>
    @endisset
</{{$element}}>
