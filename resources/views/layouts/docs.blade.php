<!doctype html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GetContent</title>
    <link rel="stylesheet" href="{{GetContent::asset('css/app.css')}}">
    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased">

<div class="flex flex-col min-h-screen">
    <header class="flex items-center p-6 text-lg font-semibold text-gray-300 bg-gray-900">
        <a href="{{route('docs.components.index')}}">GetContent UI Components</a>
        @hasSection('title')
            <x-heroicon-o-arrow-right class="h-4 mx-3"/> @yield('title')
        @endif
    </header>

    <main class="flex-grow py-12 bg-gray-50">

        @isset($slot)
            {{$slot}}
        @else
            @yield('content')
        @endisset

    </main>

    <footer class="p-6 text-gray-500">
        &copy; {{date('Y')}} Rich Standbrook
    </footer>
</div>
@livewireScripts
<script defer src="{{GetContent::asset('js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
