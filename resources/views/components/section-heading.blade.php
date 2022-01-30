<div {{$attributes->class([
    'pb-5 border-b border-gray-200 dark:border-gray-600'
])}}>
    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-300">
        {{$slot}}
    </h3>
    @isset($description)
    <p class="mt-2 max-w-4xl text-sm text-gray-500 dark:text-gray-400">
        {{$description}}
    </p>
    @endisset
</div>
