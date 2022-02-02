<div {{$attributes->class(['flex items-center px-2 rounded group'])->except(['x-model', 'href', 'title'])}}
     :class="{
        @isset($itemKey)
        'bg-blue-500 hover:bg-blue-400 text-white': inSelection('{{$itemKey}}'),
        @endif
        'hover:bg-gray-100': @isset($itemKey)!inSelection('{{$itemKey ?? null}}')@else true @endif
        }">

    @isset($xModel, $itemKey)
        <label class="h-full">
            <input type="checkbox" value="{{$itemKey}}" x-model="{{$xModel}}"
                   :class="{'opacity-0 group-hover:opacity-100': !selectedItems}">
        </label>
    @endif

    @isset($href)
        <a href="{{$href}}" class="flex flex-grow items-center py-3"
            {{$attributes->only('title')}}>

            @isset($icon)
                <div class="flex justify-center items-center mx-1 w-8 h-8 bg-white rounded-md">
                    {{$icon}}
                </div>
            @endif

            {{$slot}}
        </a>
    @else
        <div class="flex flex-grow items-center py-3" {{$attributes->get('title')}}>

            @isset($icon)
                <div class="flex justify-center items-center mx-1 w-8 h-8 bg-white rounded-md">
                    {{$icon}}
                </div>
            @endif

            {{$slot}}
        </div>
    @endif
</div>
