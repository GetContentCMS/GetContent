@props([
    'id' => Str::uuid(),
    'leadingIcon' => null,
    'trailingIcon' => null,
])
<x-gc::input-surround :attributes="$attributes" :id="$id">

    <textarea @class([
        'px-3 py-2 w-full h-18 rounded border shadow-sm resize-none',
        'text-gray-900',
        'outline-none ring-blue-500 ring-opacity-25',
        'focus:ring focus:border-blue-500',
        'disabled:pointer-events-none',

        'border-red-300 text-red-900 focus:ring-red-500 focus:ring-opacity-50 focus:border-red-500' => $attributes->has('error'),

        'pl-10' => $leadingIcon,
        'pr-10' => $trailingIcon,

        'dark:text-gray-100 dark:bg-gray-700 dark:border-gray-600',
        'dark:ring-opacity-50 dark:focus:border-blue-500 dark:disabled:bg-gray-800',
        'dark:disabled:border-gray-600 dark:disabled:placeholder-gray-600',

        'dark:border-red-500 dark:text-red-400  dark:focus:border-red-500' => $attributes->has('error'),
        ])
              id="{{$id}}"

              x-data="{
                initialHeight: null,
                    resize: () => {
                        $el.style.height = '0';
                        let calcHeight = $el.scrollHeight < this.initialHeight ? this.initialHeight : $el.scrollHeight;
                        $el.style.height = calcHeight + 'px';
                    }
                }"
              x-init="$nextTick(() => {this.initialHeight = $el.clientHeight; resize()})"
              @input="resize()"
        {{$attributes}}
    >{{$slot}}</textarea>

</x-gc::input-surround>
