@props([
    'compact' => false,
    'tight' => false,
])
@php
    $padding = 'px-4 py-5 sm:p-6';

    if($compact) {
        $padding = 'px-1 py-2 sm:p-3';
    }

    if($tight) {
        $padding = 'p-1';
    }
@endphp
<div {{$attributes->class([
    'bg-white overflow-hidden shadow rounded-lg border',
    'divide-y divide-gray-200',
    'dark:bg-gray-900 dark:divide-gray-700 dark:text-white dark:border-gray-700',
    ])}}>
    @isset($header)
        <header {{$header->attributes->class([$padding, 'font-bold'])}}>
            {{$header}}
        </header>
    @endif

    @isset($main)
        <section {{$main->attributes->class([$padding])}}>
            {{$main}}
        </section>
    @elseif($slot->isNotEmpty())
        <section class="{{$padding}}">
            {{$slot}}
        </section>
    @endif

    @isset($footer)
        <footer {{$footer->attributes->class([$padding])}}>
            {{$footer}}
        </footer>
    @endif
</div>
