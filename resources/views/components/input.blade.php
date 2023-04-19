@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block placeholder-white w-full mt-2 appearance-none text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-darkSidebar dark:text-white dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring']) !!}>
