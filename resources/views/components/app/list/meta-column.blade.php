@aware(['itemKey'])

<div class="text-sm"
     :class="{
        'text-blue-200': inSelection('{{$itemKey}}'),
        'text-gray-500': !inSelection('{{$itemKey}}')
        }">
    {{$slot}}
</div>
