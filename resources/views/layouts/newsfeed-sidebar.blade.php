<nav x-cloak @click.outside="nav = false" class="md:block sticky top-0 shadow-md bg-white overflow-y-hidden overflow-x-hidden inset-y-0 z-10 fixed md:relative flex-shrink-0 w-72 overflow-y-auto dark:bg-darkSidebar"
     :class="{'hidden': nav == false}">
    <div class="h-16 border-b dark:border-gray-600 flex px-4 py-2 gap-3 items-center">
        <img src="{{url(asset('favicon.ico'))}}" alt="" class="h-8">
    </div>
    <div class="h-screen  overflow-y-auto scrollbar-thin">
        <div class="h-48 border-b dark:border-gray-600 text-center my-4">
            <div class="block my-2">
                <img class="rounded-full p-2 mx-auto border bg-blue-500 h-20" src="https://ui-avatars.com/api/?name={{auth()->user()->name}}" alt="">
            </div>
            <span class="my-auto text-xl text-gray-500 font-medium capitalize dark:text-gray-300">{{auth()->user()->name}}</span>
            <div class="flex justify-between gap-4 p-4 capitalize mb-2">
                <div>
                    <span class="text-gray-700 font-medium dark:text-gray-300">@lang('post')</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">40</span>
                </div>
                <div>
                    <span class="text-gray-700 font-medium dark:text-gray-300">@lang('following')</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">40</span>
                </div>
                <div>
                    <span class="text-gray-700 font-medium dark:text-gray-300">@lang('followers')</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">40</span>
                </div>
            </div>
        </div>
        <div class="capitalize">
            <a href="{{route('newsfeed.home')}}" class="navMenuLink {{Route::is('newsfeed.home')?'navActive':'navInactive'}}">
                <x-h-o-newspaper class="w-6"/><span class="">@lang('newsfeed')</span>
            </a>
        @can('isAdmin')
                <a href="{{route('users')}}" class="navMenuLink {{Route::is('users')?'navActive':'navInactive'}}">
                    <x-h-o-users class="w-6"/><span class="">@lang('users')</span>
                </a>
                <a href="{{route('categories')}}" class="navMenuLink {{Route::is('categories')?'navActive':'navInactive'}}">
                    <x-h-o-cube-transparent class="w-6"/><span class="">@lang('categories')</span>
                </a>
                <a href="{{route('brands')}}" class="navMenuLink {{Route::is('brands')?'navActive':'navInactive'}}">
                    <x-h-o-cube class="w-6"/><span class="">@lang('brands')</span>
                </a>
                <a href="{{route('groups')}}" class="navMenuLink {{Route::is('groups')?'navActive':'navInactive'}}">
                    <x-h-o-server class="w-6"/><span class="">@lang('groups')</span>
                </a>
                <a href="{{route('units')}}" class="navMenuLink {{Route::is('units')?'navActive':'navInactive'}}">
                    <x-h-o-funnel class="w-6"/><span class="">@lang('units')</span>
                </a>
                <a href="{{route('products')}}" class="navMenuLink {{Route::is('products')?'navActive':'navInactive'}}">
                    <x-h-o-circle-stack class="w-6"/><span class="">@lang('products')</span>
                </a>
                <a href="{{route('purchases')}}" class="navMenuLink {{Route::is('purchases')?'navActive':'navInactive'}}">
                    <x-h-o-shopping-cart class="w-6"/><span class="">@lang('purchase')</span>
                </a>
                <a href="{{route('invoices')}}" class="navMenuLink {{Route::is('invoices')?'navActive':'navInactive'}}">
                    <x-h-o-shopping-bag class="w-6"/><span class="">@lang('invoices')</span>
                </a>
{{--                <a href="{{route('dashboard.attribute')}}" class="navMenuLink {{Route::is('dashboard.attribute')?'navActive':'navInactive'}}">--}}
{{--                    <x-h-o-shopping-bag class="w-6"/><span class="">@lang('attributes')</span>--}}
{{--                </a>--}}
{{--                <a href="{{route('dashboard.chatbot')}}" class="navMenuLink {{Route::is('dashboard.chatbot')?'navActive':'navInactive'}}">--}}
{{--                    <x-h-o-shopping-bag class="w-6"/><span class="">@lang('chatbot')</span>--}}
{{--                </a>--}}
{{--                <a href="{{route('setup')}}" class="navMenuLink {{Route::is('setup')?'navActive':'navInactive'}}">--}}
{{--                    <x-h-o-server class="w-6"/><span class="">@lang('setup')</span>--}}
{{--                </a>--}}
            @endcan
            {{--                <a href="{{route('units')}}" class="navMenuLink {{Route::is('units')?'navActive':'navInactive'}}">--}}
            {{--                    <x-h-o-funnel class="w-6"/><span class="">units</span>--}}
            {{--                </a>--}}

            <div  x-data="{setup: false}">
                <div @click="setup= !setup"  class="navMenuLink dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="">setup</span>
                    <svg x-show="!setup" class="w-4 ml-auto" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <svg x-show="setup" class="w-4 ml-auto" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                {{--                <div x-show="setup" class="text-sm" x-collapse>--}}
                {{--                    <a href="{{route('admin.setup.label')}}" class="subNavMenuLink {{Route::is('admin.setup.label')?'subNavActive':'subNavInactive'}}">--}}
                {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />--}}
                {{--                        </svg>--}}
                {{--                        <span class="">class</span>--}}
                {{--                    </a>--}}
                {{--                    <a href="{{route('admin.setup.group')}}" class="subNavMenuLink {{Route::is('admin.setup.group')?'subNavActive':'subNavInactive'}}">--}}
                {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />--}}
                {{--                        </svg>--}}
                {{--                        <span class="">group</span>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
            </div>

        </div>
    </div>

</nav>
