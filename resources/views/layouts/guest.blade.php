<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library System') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen flex items-center justify-center selection:bg-blue-500 selection:text-white relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-100">

        {{-- Decorative floating shapes --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            {{-- Large circle top-left --}}
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-200 rounded-full opacity-20 animate-pulse-soft"></div>
            {{-- Small circle bottom-right --}}
            <div class="absolute -bottom-16 -right-16 w-72 h-72 bg-blue-300 rounded-full opacity-15 animate-pulse-soft" style="animation-delay: 2s;"></div>
            {{-- Floating book icon 1 --}}
            <div class="absolute top-1/4 right-[15%] animate-float opacity-10">
                <svg class="w-20 h-20 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                </svg>
            </div>
            {{-- Floating book icon 2 --}}
            <div class="absolute bottom-1/4 left-[10%] animate-float-delayed opacity-10">
                <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                </svg>
            </div>
            {{-- Floating book icon 3 --}}
            <div class="absolute top-[60%] right-[8%] animate-float-slow opacity-[0.07]">
                <svg class="w-24 h-24 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                </svg>
            </div>
            {{-- Dots pattern --}}
            <div class="absolute top-10 left-[20%] opacity-[0.06]">
                <div class="grid grid-cols-5 gap-4">
                    @for($i = 0; $i < 25; $i++)
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Card --}}
        <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-white/90 backdrop-blur-sm shadow-xl sm:rounded-2xl border border-gray-100 animate-fade-in">
            {{ $slot }}
        </div>

    </body>
</html>