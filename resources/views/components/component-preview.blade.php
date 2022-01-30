@props([
    'name',
    'label' => null,
    'componentAttributes' => null,
    'noDisabled' => false,
])

<article class="p-6 space-y-3 border-b" {{$attributes}}>
    <h2 class="text-lg font-semibold">{{$label ?? Str::title($name)}}</h2>

    <div class="grid grid-cols-2 gap-3">

        <pre class="block overflow-scroll p-2 w-full font-mono text-gray-600"
        >@isset($code){{$code}}@else{!! e("<x-gc::$name $componentAttributes />") !!}@endisset</pre>

        <section class="flex flex-col items-stretch rounded-md border shadow-inner">

            <div class="flex-grow p-6 bg-gray-100 rounded-t-md">
                @if($slot->isEmpty())
                    <x-dynamic-component :component="'gc::'.$name"/>
                @else
                    {{$slot}}
                @endif

                @unless($noDisabled)
                    <div class="mt-2">
                        @isset($disabled)
                            {{$disabled}}
                        @else
                            <x-dynamic-component :component="'gc::'.$name" disabled/>
                        @endisset
                    </div>
                @endunless
            </div>

            <div class="flex-grow p-6 bg-gray-800 rounded-b-md dark">
                @if(isset($dark))
                    {{$dark}}
                @elseif($slot->isNotEmpty())
                    {{$slot}}
                @else
                    <x-dynamic-component :component="'gc::'.$name"/>
                @endif

                @unless($noDisabled)
                    <div class="mt-2">
                        @isset($disabled)
                            {{$disabled}}
                        @else
                            <x-dynamic-component :component="'gc::'.$name" disabled/>
                        @endisset
                    </div>
                @endunless
            </div>

        </section>
    </div>
</article>
