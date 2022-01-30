@props([
    'id' => Str::uuid(),
    'active' => false
])
<div x-cloak x-show="_selected('{{$id}}')" @if($active)x-init="_select('{{$id}}')"@endif
    class="p-2 text-gray-900 dark:text-gray-100">
    {{$slot}}
</div>
