@extends('layouts.base')

@section('body')
    <div class="dark:bg-darkBg flex  "
         :class="{ 'overflow-hidden': nav }"
    >
        <div x-cloak
             x-show="nav"
             x-transition:enter="transition ease-in-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        ></div>
        @php
            if (!is_null(request()->route())) {
            $pageName = request()->route()->getName();
            $routePrefix = explode('.', $pageName)[0] ?? '';
            }
        @endphp
        @if($routePrefix == "newsfeed")
            @include('layouts.newsfeed-sidebar')
        @else
        @include('layouts.sidebar')
        @endif
        <div class="flex flex-col flex-1 w-full">
            @if($routePrefix == "newsfeed")
                @include('layouts.newsfeed-header')
            @else
                <livewire:header-component />
            @endif

            <main class="h-full overflow-y-auto  @if($routePrefix == "newsfeed") bg-gray-100 h-screen @endif dark:bg-darkBg">
                <div class="m-2">

                    @yield('content')

                    @isset($slot)
                        {{ $slot }}
                    @endisset
                </div>
            </main>
        </div>
    </div>


@endsection
