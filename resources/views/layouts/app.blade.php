@extends('gc::layouts.page')

@section('body')
    <div class="flex min-h-screen">
        <div class="flex flex-col pt-5 w-64">
            <x-gc::editor.nav/>
        </div>
        <div class="w-full">
            @isset($slot)
                {{$slot}}
            @else
                @yield('content')
            @endisset
        </div>
    </div>
@endsection
