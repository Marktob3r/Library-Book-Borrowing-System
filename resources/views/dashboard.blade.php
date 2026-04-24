<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Library Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Books Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
                    <div class="relative p-8 bg-gradient-to-br from-blue-500 to-blue-600">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-blue-400 rounded-full opacity-20 -mr-8 -mt-8"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-semibold mb-2">Total Books</p>
                                    <p class="text-white text-4xl font-bold">{{ $totalBooks }}</p>
                                </div>
                                <svg class="w-12 h-12 text-blue-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    <path fill-rule="evenodd" d="M3 7a1 1 0 011-1h12a1 1 0 011 1v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7zm12-1a1 1 0 00-1 1v10H4V7a1 1 0 00-1-1h12z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-blue-100 text-xs mt-4">In the library inventory</p>
                        </div>
                    </div>
                </div>

                <!-- Available Books Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
                    <div class="relative p-8 bg-gradient-to-br from-green-500 to-green-600">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-green-400 rounded-full opacity-20 -mr-8 -mt-8"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-semibold mb-2">Available</p>
                                    <p class="text-white text-4xl font-bold">{{ $availableBooks }}</p>
                                </div>
                                <svg class="w-12 h-12 text-green-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-green-100 text-xs mt-4">Ready to borrow</p>
                        </div>
                    </div>
                </div>

                <!-- Borrowed Books Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
                    <div class="relative p-8 bg-gradient-to-br from-amber-500 to-amber-600">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-amber-400 rounded-full opacity-20 -mr-8 -mt-8"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-amber-100 text-sm font-semibold mb-2">Borrowed</p>
                                    <p class="text-white text-4xl font-bold">{{ $borrowedBooks }}</p>
                                </div>
                                <svg class="w-12 h-12 text-amber-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                            <p class="text-amber-100 text-xs mt-4">Currently checked out</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions Section -->
            <div class="bg-white overflow-hidden rounded-xl shadow-md">
                <div class="px-8 py-6 border-b-2 border-blue-100 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    <path fill-rule="evenodd" d="M3 7a1 1 0 011-1h12a1 1 0 011 1v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7zm12-1a1 1 0 00-1 1v10H4V7a1 1 0 00-1-1h12z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                                <p class="text-sm text-gray-500">Latest borrow activity</p>
                            </div>
                        </div>
                        <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-2 transition">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-center">
                            <span class="font-semibold">No transactions yet</span><br>
                            <span class="text-sm">Borrow transactions will appear here</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quick Stats Info -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">i</span>
                        System Overview
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <span class="text-gray-600">Inventory Status</span>
                            <span class="text-blue-600 font-bold">{{ $totalBooks }} Books</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <span class="text-gray-600">Available Now</span>
                            <span class="text-green-600 font-bold">{{ $availableBooks }} Books</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">In Circulation</span>
                            <span class="text-amber-600 font-bold">{{ $borrowedBooks }} Books</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">+</span>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('books.create') }}" class="block p-3 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg text-blue-700 font-semibold transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Add New Book
                        </a>
                        <a href="{{ route('books.index') }}" class="block p-3 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-lg text-gray-700 font-semibold transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            View Book Catalog
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>