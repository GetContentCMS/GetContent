<!doctype html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GetContent</title>
    @foreach(GetContent::getStyles() as $style)
    <link rel="stylesheet" href="{{$style}}">
    @endforeach
    <link rel="stylesheet" href="{{GetContent::asset('css/app.css')}}">
    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-800">

@yield('body')

<x-gc::notifications/>

@livewireScripts
<script defer src="{{GetContent::asset('js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
