<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Account Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 relative animate-fade-in">
        {{-- Decorative background shapes --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-200 rounded-full opacity-10 animate-pulse-soft"></div>
            <div class="absolute top-1/2 -left-32 w-80 h-80 bg-blue-300 rounded-full opacity-10 animate-pulse-soft" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 relative z-10 stagger">
            
            <div class="p-6 sm:p-8 bg-white shadow-md sm:rounded-xl border border-gray-50 animate-slide-up relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-transparent opacity-20 rounded-bl-full pointer-events-none"></div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow-md sm:rounded-xl border border-gray-50 animate-slide-up relative overflow-hidden group" style="animation-delay: 100ms;">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-transparent opacity-20 rounded-bl-full pointer-events-none"></div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow-md sm:rounded-xl border border-gray-50 animate-slide-up relative overflow-hidden group" style="animation-delay: 200ms;">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-100 to-transparent opacity-20 rounded-bl-full pointer-events-none"></div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>