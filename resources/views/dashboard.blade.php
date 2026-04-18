<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Total Books in Inventory</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalBooks }}</div> </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Available Books</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $availableBooks }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm">Currently Borrowed</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $borrowedBooks }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200 font-semibold text-lg">
                    Recent Transactions
                </div>
                <div class="p-6 text-gray-500 text-center">
                    No recent transactions found.
                </div>
            </div>

        </div>
    </div>
</x-app-layout>