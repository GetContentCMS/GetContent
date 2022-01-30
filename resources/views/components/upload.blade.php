<div class="flex items-center space-x-2" {{$attributes->except(['id', 'wire:model', 'accept'])}}>
    <x-heroicon-o-upload class="w-5 h-5 dark:text-gray-100 flex-shrink-0"/>

    <input type="file" x-ref="fileInput"
        {{$attributes}}
        {{$attributes->class([
            'file:px-2 file:py-1 file:rounded flex items-center justify-center',
            'file:focus-outline',

            'file:text-gray-900 file:active:bg-gray-50',
            'file:bg-white file:border file:border-solid file:border-gray-300 file:shadow-sm',

            'file:disabled:opacity-50 file:disabled:shadow-none file:disabled:pointer-events-none',

            'file:dark:text-gray-100 dark:text-gray-300',
            'file:dark:border-gray-600 file:dark:bg-gray-700',
            'file:dark:active:bg-gray-600',
            ])}}>
</div>
