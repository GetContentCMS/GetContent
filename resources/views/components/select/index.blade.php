@props([
    'id' => null,
])
<x-gc::input-surround :attributes="$attributes->only(['id', 'label', 'help', 'error', 'class'])" :id="$id">

    <div class="contents relative" x-data>
        <select @class([
        'appearance-none px-3 py-2 pr-8 w-full rounded border shadow-sm focus-outline',
        'text-gray-900',
        'disabled:pointer-events-none disabled:opacity-60',

        'border-red-300 text-red-900 focus:ring-red-500 focus:ring-opacity-50 focus:border-red-500' => $attributes->get('error'),

        'dark:text-gray-100 dark:bg-gray-700 dark:border-gray-600',
        'dark:ring-opacity-50 dark:disabled:bg-gray-800',
        'dark:disabled:border-gray-600 dark:disabled:placeholder-gray-600',

        'dark:border-red-500 dark:text-red-400  dark:focus:border-red-500' => $attributes->get('error'),

        ]) {{$attributes->merge(['id' => $id])}} x-ref="select">
            {{$slot}}
        </select>
        <div class="flex absolute inset-0 justify-end items-center pointer-events-none pr-2">
            <x-heroicon-s-selector class="w-5 h-5 dark:text-gray-100"
                                   ::class="{'opacity-40': $refs.select.disabled}"/>
        </div>
    </div>

</x-gc::input-surround>
