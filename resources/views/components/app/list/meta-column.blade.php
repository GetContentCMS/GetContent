@aware(['itemKey'])

<div {{$attributes->class('text-sm flex-none truncate')}}
     :class="{
        'text-blue-200': inSelection('{{$itemKey}}'),
        'text-gray-500': !inSelection('{{$itemKey}}')
        }">
    {{$slot}}
</div>
