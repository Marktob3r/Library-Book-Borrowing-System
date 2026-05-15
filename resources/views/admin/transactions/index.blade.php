<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Borrow Transactions') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Issue Book
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden">
        {{-- Decorative background shapes --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-200 rounded-full opacity-10 animate-pulse-soft"></div>
            <div class="absolute bottom-20 -left-20 w-72 h-72 bg-blue-300 rounded-full opacity-10 animate-pulse-soft" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

            <!-- Filters -->
            <div class="bg-white p-6 rounded-xl shadow-md mb-8 animate-slide-up border border-blue-50">
                <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="w-full sm:w-1/3">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Student Name, ID, or Book Title..." class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                        </div>
                    </div>
                    
                    <div class="w-full sm:w-1/4">
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            <option value="">All Transactions</option>
                            <option value="Borrowed" {{ $status === 'Borrowed' ? 'selected' : '' }}>Currently Borrowed</option>
                            <option value="Returned" {{ $status === 'Returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-bold shadow-sm hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            Filter
                        </button>
                    </div>
                    
                    @if($search || $status)
                        <div class="w-full sm:w-auto">
                            <a href="{{ route('transactions.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 text-gray-600 hover:text-gray-900 font-semibold transition-colors">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-50 animate-slide-up" style="animation-delay: .1s;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-50/80 text-gray-700 uppercase text-[11px] font-bold border-b-2 border-blue-100">
                                <th class="py-4 px-6 text-left">Student Info</th>
                                <th class="py-4 px-6 text-left">Book Info</th>
                                <th class="py-4 px-6 text-left">Dates</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-900">{{ $transaction->student->first_name ?? 'Unknown' }} {{ $transaction->student->last_name ?? '' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                            ID: {{ $transaction->student->student_id_number ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-900">{{ $transaction->book->title ?? 'Unknown Book' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">ISBN: {{ $transaction->book->isbn ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-sm font-medium text-gray-700">Borrowed: {{ $transaction->borrowed_at->format('M d, Y h:i A') }}</div>
                                        @if($transaction->returned_at)
                                            <div class="text-xs font-semibold text-green-600 mt-0.5">Returned: {{ $transaction->returned_at->format('M d, Y h:i A') }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                            {{ $transaction->status === 'Borrowed' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-green-100 text-green-700 border border-green-200' }}">
                                            @if($transaction->status === 'Borrowed')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @endif
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if($transaction->status === 'Borrowed')
                                            <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure you want to mark this book as returned?')" class="inline-flex items-center px-4 py-2 bg-white border-2 border-green-500 text-green-600 rounded-lg font-bold text-xs hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors shadow-sm">
                                                    Mark Returned
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center px-4 py-2 bg-gray-50 border-2 border-gray-200 text-gray-400 rounded-lg font-bold text-xs cursor-not-allowed">
                                                Resolved
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900">No Transactions Found</h3>
                                            <p class="text-gray-500 text-sm mt-1 max-w-sm">There are no borrow transactions matching your current filters.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 animate-slide-up" style="animation-delay: .2s;">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
