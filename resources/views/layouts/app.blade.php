<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library Book Borrowing System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b-2 border-blue-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>

        {{-- ─── Toast Notification System ─── --}}
        <div x-data="{
                toasts: [],
                addToast(message, type) {
                    const id = Date.now();
                    this.toasts.push({ id, message, type });
                    setTimeout(() => this.removeToast(id), 4500);
                },
                removeToast(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                },
                init() {
                    @if(session('success'))
                        this.addToast('{{ session('success') }}', 'success');
                    @endif
                    @if(session('error'))
                        this.addToast('{{ session('error') }}', 'error');
                    @endif
                    @if(session('info'))
                        this.addToast('{{ session('info') }}', 'info');
                    @endif
                }
            }"
            class="fixed top-5 right-5 z-[100] flex flex-col gap-3 max-w-sm w-full pointer-events-none"
            x-cloak>

            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="translate-x-0 opacity-100"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="pointer-events-auto bg-white rounded-xl shadow-2xl border overflow-hidden"
                     :class="{
                        'border-green-200': toast.type === 'success',
                        'border-red-200':   toast.type === 'error',
                        'border-blue-200':  toast.type === 'info'
                     }">

                    {{-- Progress bar --}}
                    <div class="h-1 rounded-full animate-[shrink_4.5s_linear_forwards]"
                         :class="{
                            'bg-green-500': toast.type === 'success',
                            'bg-red-500':   toast.type === 'error',
                            'bg-blue-500':  toast.type === 'info'
                         }"></div>

                    <div class="p-4 flex items-start gap-3">
                        {{-- Icon --}}
                        <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center"
                             :class="{
                                'bg-green-100': toast.type === 'success',
                                'bg-red-100':   toast.type === 'error',
                                'bg-blue-100':  toast.type === 'info'
                             }">
                            {{-- Success icon --}}
                            <svg x-show="toast.type === 'success'" class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{-- Error icon --}}
                            <svg x-show="toast.type === 'error'" class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{-- Info icon --}}
                            <svg x-show="toast.type === 'info'" class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        {{-- Message --}}
                        <p class="text-sm font-semibold text-gray-800 flex-1 pt-1" x-text="toast.message"></p>

                        {{-- Close --}}
                        <button @click="removeToast(toast.id)" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <style>
            @keyframes shrink { from { width: 100%; } to { width: 0%; } }
        </style>
    </body>
</html>
