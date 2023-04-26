<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">
    @vite(['resources/css/app.css'])
    @livewireStyles
    @vite(['resources/js/app.js'])
    @stack('js')
</head>
<body class="dark:bg-danger text-tahiti scrollbar-none" x-data="{darkTheme: $persist(false)}" :class="{'dark': darkTheme}">
{{$slot}}
@livewireScripts
<script src="{{ asset('js/sa.js') }}"></script>
<x-livewire-alert::scripts />
<script src="{{ asset('js/spa.js') }}" data-turbolinks-eval="false"></script>
</body>
</html>
