<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Library Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden">
        {{-- Decorative background shapes --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-200 rounded-full opacity-10 animate-pulse-soft"></div>
            <div class="absolute bottom-20 -left-20 w-72 h-72 bg-blue-300 rounded-full opacity-10 animate-pulse-soft" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 right-[5%] animate-float opacity-[0.04]">
                <svg class="w-32 h-32 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                </svg>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 stagger">
                <!-- Total Books Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 animate-slide-up">
                    <div class="relative p-8 bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-400 rounded-full opacity-20 -mr-10 -mt-10 animate-pulse-soft"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-blue-300 rounded-full opacity-10 -ml-6 -mb-6"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-semibold mb-2">Total Books</p>
                                    <p class="text-white text-4xl font-bold animate-count-pop">{{ $totalBooks }}</p>
                                </div>
                                <svg class="w-12 h-12 text-blue-300 opacity-50" fill="currentColor" viewBox="0 -960 960 960"><path d="M96-192v-72h768v72H96Zm120-144v-288h72v288h-72Zm144 0v-432h72v432h-72Zm144 0v-432h72v432h-72Zm224 0L624-597l67-27 104 261-67 27Z"/></svg>
                            </div>
                            <p class="text-blue-100 text-xs mt-4">In the library inventory</p>
                        </div>
                    </div>
                </div>

                <!-- Available Books Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 animate-slide-up">
                    <div class="relative p-8 bg-gradient-to-br from-green-500 to-green-600 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-400 rounded-full opacity-20 -mr-10 -mt-10 animate-pulse-soft"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-300 rounded-full opacity-10 -ml-6 -mb-6"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-semibold mb-2">Available</p>
                                    <p class="text-white text-4xl font-bold animate-count-pop" style="animation-delay: .1s;">{{ $availableBooks }}</p>
                                </div>
                                <svg class="w-12 h-12 text-green-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-green-100 text-xs mt-4">Ready to borrow</p>
                        </div>
                    </div>
                </div>

                <!-- Borrowed Books Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 animate-slide-up">
                    <div class="relative p-8 bg-gradient-to-br from-amber-500 to-amber-600 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-400 rounded-full opacity-20 -mr-10 -mt-10 animate-pulse-soft"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-amber-300 rounded-full opacity-10 -ml-6 -mb-6"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-amber-100 text-sm font-semibold mb-2">Borrowed</p>
                                    <p class="text-white text-4xl font-bold animate-count-pop" style="animation-delay: .2s;">{{ $borrowedBooks }}</p>
                                </div>
                                <svg class="w-12 h-12 text-amber-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                            <p class="text-amber-100 text-xs mt-4">Currently checked out</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions Section -->
            <div class="bg-white overflow-hidden rounded-xl shadow-md animate-slide-up" style="animation-delay: .3s;">
                <div class="px-8 py-6 border-b-2 border-blue-100 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                                    <path fill-rule="evenodd" d="M3 9a1 1 0 011-1h12a1 1 0 011 1v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                                <p class="text-sm text-gray-500">Latest borrow activity</p>
                            </div>
                        </div>
                        <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-2 transition group">
                            View All
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-8">
                    @if($recentTransactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-blue-50 text-gray-700 uppercase text-[11px] font-bold border-b border-blue-200">
                                        <th class="py-3 px-6">Student</th>
                                        <th class="py-3 px-6">Book</th>
                                        <th class="py-3 px-6">Date Borrowed</th>
                                        <th class="py-3 px-6">Date Returned</th>
                                        <th class="py-3 px-6 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-blue-100">
                                    @foreach($recentTransactions as $transaction)
                                        <tr class="hover:bg-blue-50/80 transition-colors duration-150">
                                            <td class="py-4 px-6 text-sm font-semibold text-gray-900">{{ $transaction->student->full_name ?? '—' }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->book->title ?? '—' }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->borrowed_at->format('M d, Y') }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->returned_at ? $transaction->returned_at->format('M d, Y') : '—' }}</td>
                                            <td class="py-4 px-6 text-center">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                    {{ $transaction->status === 'Borrowed' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                                    {{ $transaction->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 text-center">
                                <span class="font-semibold">No transactions yet</span><br>
                                <span class="text-sm">Borrow transactions will appear here</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 stagger">
                <!-- Quick Stats Info -->
                <div class="bg-white rounded-xl shadow-md p-8 animate-slide-up hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-md">i</span>
                        System Overview
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100 group hover:border-blue-100 transition-colors">
                            <span class="text-gray-600 group-hover:text-gray-800 transition-colors">Inventory Status</span>
                            <span class="text-blue-600 font-bold">{{ $totalBooks }} Books</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100 group hover:border-green-100 transition-colors">
                            <span class="text-gray-600 group-hover:text-gray-800 transition-colors">Available Now</span>
                            <span class="text-green-600 font-bold">{{ $availableBooks }} Books</span>
                        </div>
                        <div class="flex justify-between items-center group hover:border-amber-100 transition-colors">
                            <span class="text-gray-600 group-hover:text-gray-800 transition-colors">In Circulation</span>
                            <span class="text-amber-600 font-bold">{{ $borrowedBooks }} Books</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-md p-8 animate-slide-up hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-md">+</span>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('books.create') }}" class="block p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg text-blue-700 font-semibold transition-all duration-200 flex items-center gap-3 group hover:shadow-md">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Add New Book
                            <svg class="w-4 h-4 ml-auto group-hover:translate-x-1 transition-transform text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('books.index') }}" class="block p-4 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-lg text-gray-700 font-semibold transition-all duration-200 flex items-center gap-3 group hover:shadow-md">
                            <div class="w-8 h-8 bg-gray-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                                </svg>
                            </div>
                            View Book Catalog
                            <svg class="w-4 h-4 ml-auto group-hover:translate-x-1 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

</x-app-layout>