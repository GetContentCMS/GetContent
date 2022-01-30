<header class="flex flex-shrink-0 items-center px-4 space-x-2">
    <figure class="p-2 text-indigo-50 bg-indigo-700 rounded-full">
        <x-heroicon-s-collection class="w-5 h-5"></x-heroicon-s-collection>
    </figure>
    <span class="text-lg font-bold tracking-tighter text-indigo-300">
        GetContent
    </span>
</header>

<div class="overflow-y-auto flex-1 mt-5 h-0">
    <nav class="px-2">
        <div class="space-y-1">
            @foreach($nav as $link)
                @if($link->isCurrent())
                    <a href="{{ $link->route() ?? $link->url() }}"
                       class="flex items-center px-2 py-2 text-sm font-medium text-gray-200 bg-gray-900 rounded-md group"
                       aria-current="page">
                        @if($link->icon())
                            <x-dynamic-component :component="$link->icon()"
                                                 class="mr-3 h-6 text-yellow-500 w-66"/>
                        @endif
                        {{ $link->name() }}
                    </a>
                @else
                    <a href="{{ $link->route() ?? $link->url() }}"
                       class="flex items-center px-2 py-2 text-sm font-medium text-gray-400 rounded-md group hover:text-gray-200 hover:bg-gray-700"
                       aria-current="page">
                        @if($link->icon())
                            <x-dynamic-component :component="$link->icon()"
                                                 class="mr-3 h-6 text-gray-500 group-hover:text-gray-400 w-66"></x-dynamic-component>
                        @endif
                        {{$link->name()}}
                    </a>
                @endif
            @endforeach
        </div>

        {{--<div class="mt-8">
            <h3 class="px-3 text-xs font-semibold tracking-wider text-gray-500 uppercase"
                id="teams-headline">
                Recent Documents
            </h3>
            <div class="mt-1 space-y-1" role="group" aria-labelledby="teams-headline">
                <a href="#"
                   class="flex items-center px-3 py-2 text-base font-medium leading-5 text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                    <span class="w-2.5 h-2.5 mr-4 bg-indigo-500 rounded-full"
                          aria-hidden="true"></span>
                    <span class="truncate">
                        A recently edited document
                    </span>
                </a>
            </div>
        </div>--}}
    </nav>
</div>

<footer
    class="sticky bottom-0 p-4 m-2 text-xs text-center text-gray-400 bg-gray-700 rounded transition duration-300 cursor-pointer hover:text-gray-200 hover:bg-gray-600">
    GetContent {{GetContent::version()}}
    @if(config('app.env') === 'local')
        <span
            class="relative inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500 text-green-200">
        Local Env
    </span>
    @endif
</footer>
