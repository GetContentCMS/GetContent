@aware(['itemKey'])

<div {{$attributes->class('text-sm')}}
     :class="{
        'text-blue-200': inSelection('{{$itemKey}}'),
        'text-gray-500': !inSelection('{{$itemKey}}')
        }">
    {{$slot}}
</div>
