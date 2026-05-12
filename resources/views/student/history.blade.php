<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Borrowing History') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden">
        {{-- Decorative background --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-200 rounded-full opacity-10 animate-pulse-soft"></div>
            <div class="absolute bottom-10 -left-16 w-64 h-64 bg-blue-300 rounded-full opacity-10 animate-pulse-soft" style="animation-delay: 3s;"></div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">

            {{-- Filter Tabs --}}
            <div class="bg-white rounded-xl shadow-md p-5 mb-8 border border-blue-50 animate-fade-in">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('student.history') }}"
                       class="px-5 py-2 rounded-lg font-semibold text-sm transition-all duration-200
                           {{ !request('status') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md' : 'bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200' }}">
                        All
                    </a>
                    <a href="{{ route('student.history', ['status' => 'Borrowed']) }}"
                       class="px-5 py-2 rounded-lg font-semibold text-sm transition-all duration-200
                           {{ request('status') === 'Borrowed' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md' : 'bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200' }}">
                        Currently Borrowed
                    </a>
                    <a href="{{ route('student.history', ['status' => 'Returned']) }}"
                       class="px-5 py-2 rounded-lg font-semibold text-sm transition-all duration-200
                           {{ request('status') === 'Returned' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md' : 'bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200' }}">
                        Returned
                    </a>
                </div>
            </div>

            {{-- Transactions Table --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-50 animate-slide-up" style="animation-delay: .15s;">
                @if($transactions->count() > 0)
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 z-20">
                                <tr class="bg-blue-50 text-gray-700 uppercase text-[11px] font-bold border-b border-blue-200">
                                    <th class="py-3 px-6">Book Title</th>
                                    <th class="py-3 px-6">Author</th>
                                    <th class="py-3 px-6">ISBN</th>
                                    <th class="py-3 px-6">Borrowed Date</th>
                                    <th class="py-3 px-6">Returned Date</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100">
                                @foreach($transactions as $transaction)
                                    <tr class="hover:bg-blue-50/80 transition-colors duration-150">
                                        <td class="py-4 px-6 text-sm font-semibold text-gray-900">{{ $transaction->book->title }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->book->author }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-500 font-mono">{{ $transaction->book->isbn }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->borrowed_at->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-600">
                                            {{ $transaction->returned_at ? $transaction->returned_at->format('M d, Y') : '—' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                {{ $transaction->status === 'Borrowed' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $transaction->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            @if($transaction->status === 'Borrowed')
                                                <form action="{{ route('student.return-book', $transaction->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-tighter transition-all duration-200">
                                                        Return
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-sm">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($transactions->hasPages())
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-t border-blue-100">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-center font-semibold mb-1">No transactions yet</p>
                        <p class="text-gray-400 text-sm mb-4">
                            @if(request('status'))
                                No {{ strtolower(request('status')) }} books found.
                            @else
                                You haven't borrowed any books yet.
                            @endif
                        </p>
                        <a href="{{ route('student.browse-books') }}"
                           class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg text-sm shadow-md transition-all duration-200">
                            Browse Books
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
