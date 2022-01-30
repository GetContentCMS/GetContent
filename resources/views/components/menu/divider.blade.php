@props(['vertical' => false])

@if($vertical)
    <div {{$attributes->merge(['class' => 'h-8 w-0 px-2'])}} role="none">
        <div class="h-full border-r-2 border-gray-200 dark:border-gray-600"></div>
    </div>
@else
    <div {{$attributes->merge(['class' => 'py-1 px-4 w-full'])}} role="none">
        <hr class="border-gray-300 dark:border-gray-600"/>
    </div>
@endif
