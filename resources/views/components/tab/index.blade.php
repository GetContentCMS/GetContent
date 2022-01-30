@props([
    'for',
    'label' => null,
    'active' => false
])
<div x-data="{select: () => _select('{{$for}}'), selected: () => _selected('{{$for}}') }"
     @if($active)x-init="select"@endif>
    @if($label)
        <button @class([
                    'text-gray-600 hover:text-gray-800 px-3 py-2 font-semibold text-sm rounded-md',
                    'active:bg-gray-100',
                    'ring-blue-500 ring-opacity-25 outline-none focus:ring focus:border-blue-500',

                    'dark:text-gray-400 dark:active:bg-gray-600',
                    'dark:ring-opacity-50 dark:focus:border-blue-500',

                    'disabled:opacity-50 disabled:pointer-events-none'
                ])
                :class="{
                    'bg-gray-200 text-gray-800': selected(),
                    'dark:bg-gray-700 dark:text-gray-200':selected()
                }"
                :aria-current="selected()"
                @click="select"
            {{$attributes->except('class')}}>
            <div>{{$label}}</div>
        </button>
    @else
        {{$slot}}
    @endif
</div>
