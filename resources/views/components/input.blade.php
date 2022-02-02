@props([
    'id' => null,
    'leadingIcon' => null,
    'trailingIcon' => null,
])
<x-gc::input-surround :attributes="$attributes->only(['id', 'label', 'help', 'error', 'class'])" :id="$id">

    <input @class([
        'px-3 py-2 w-full rounded border shadow-sm focus-outline',
        'text-gray-900',
        'disabled:pointer-events-none',

        'border-red-300 text-red-900 focus:ring-red-500 focus:ring-opacity-50 focus:border-red-500' => $attributes->has('error'),

        'pl-10' => $leadingIcon,
        'pr-10' => $trailingIcon,

        'dark:text-gray-100 dark:bg-gray-700 dark:border-gray-600',
        'dark:ring-opacity-50 dark:disabled:bg-gray-800',
        'dark:disabled:border-gray-600 dark:disabled:placeholder-gray-600',

        'dark:border-red-500 dark:text-red-400  dark:focus:border-red-500' => $attributes->has('error'),

        ]) {{$attributes->merge(['type' => 'text', 'id' => $id])->except(['label'])}}>

</x-gc::input-surround>
