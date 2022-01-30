@props([
    'id' => Str::uuid(),
    'trueValue' => true,
    'falseValue' => false
    ])
<x-gc::input-surround :attributes="$attributes->only(['id', 'label', 'help', 'error', 'class'])" :id="$id">


    <div x-data="{checked: null}"
         x-init="checked = $refs.checkbox.checked"
        {{$attributes->get('class')}}>
        <input type="checkbox" value="{{$trueValue}}"
               {{$attributes->thatStartWith('wire:model')}}
               id="{{$attributes->get('id')}}"
               x-model="checked"
               x-ref="checkbox"
               class="hidden"
            @if($attributes->has('x-model'))
                x-init="$watch('{{$attributes->get('x-model')}}', value => checked = {{$attributes->get('x-model')}} === '{{$trueValue}}')"
               @change="{{$attributes->get('x-model')}} = checked ? '{{$trueValue}}' : '{{$falseValue}}'"
            @endif
        >
        <button type="button" {{$attributes}} id="{{$id}}"
                @class([
                    'inline-flex relative flex-shrink-0 w-11 h-6 cursor-pointer focus-outline',
                    'rounded-full border-2 border-transparent',
                    'transition-colors duration-200 ease-in-out',
                    'disabled:opacity-50'
                ])
                :class="{
                    'bg-gray-300 dark:bg-gray-600': !checked,
                    'bg-blue-500': checked
                }"
                @click="$refs.checkbox.click()"
                role="switch" aria-checked="false" aria-labelledby="privacy-option-2-label"
                aria-describedby="privacy-option-2-description">
            <div aria-hidden="true"
                 class="inline-block w-5 h-5 bg-white rounded-full ring-0 shadow transition duration-200 ease-in-out transform"
                 :class="{
                    'translate-x-0': !checked,
                    'translate-x-5': checked
                 }"
            ></div>
        </button>

    </div>
</x-gc::input-surround>
