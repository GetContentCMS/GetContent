@props([
    'selected' => false
])
<div class="flex justify-between p-1">
    <button {{$attributes}}
            @click="open = false"
            @class([
                'group flex items-center px-2 py-2 w-full text-sm rounded border border-transparent select-none',
                'hover:bg-blue-500 hover:text-white focus:bg-blue-500 focus:text-white',
                'outline-none ring-blue-500 ring-opacity-25',
                'focus:ring focus:border-blue-600',

                'disabled:pointer-events-none disabled:opacity-50',

                'dark:focus:border-blue-300 dark:ring-blue-800',

                'text-gray-800 dark:text-gray-300 dark:hover:text-white dark:focus:text-white' => !$selected,
                'text-black dark:text-white' => $selected,
                ])>

        <div @class([
            'mr-3 w-5 h-5 group-hover:text-blue-100 group-focus:text-blue-100 flex-none',
            'text-gray-500 dark:text-gray-400' => !$selected,
            'text-black dark:text-white' => $selected,
            ])>
            {{$icon ?? null}}
        </div>

        <div class="w-full text-left truncate">
            {{$slot}}
        </div>

        @if($selected)
            <x-heroicon-o-check class="flex-none -mr-1 w-5 h-5"/>
        @endif
    </button>
</div>
