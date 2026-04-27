<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Borrowing History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="mb-6 flex gap-2">
                <a href="{{ route('student.history') }}" class="px-4 py-2 rounded-lg font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }} transition">
                    All
                </a>
                <a href="{{ route('student.history', ['status' => 'Borrowed']) }}" class="px-4 py-2 rounded-lg font-medium {{ request('status') === 'Borrowed' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }} transition">
                    Currently Borrowed
                </a>
                <a href="{{ route('student.history', ['status' => 'Returned']) }}" class="px-4 py-2 rounded-lg font-medium {{ request('status') === 'Returned' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }} transition">
                    Returned
                </a>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Book Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">ISBN</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Borrowed Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Returned Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($transactions as $transaction)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $transaction->book->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ $transaction->book->author }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 font-mono text-sm">
                                            {{ $transaction->book->isbn }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ $transaction->borrowed_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            {{ $transaction->returned_at ? $transaction->returned_at->format('M d, Y') : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->status === 'Borrowed')
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs font-semibold rounded-full">
                                                    Borrowed
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs font-semibold rounded-full">
                                                    Returned
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->status === 'Borrowed')
                                                <form action="{{ route('student.return-book', $transaction->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-block px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded transition">
                                                        Return Book
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            No transactions yet
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            @if(request('status'))
                                No {{ strtolower(request('status')) }} books.
                            @else
                                You haven't borrowed any books yet.
                            @endif
                        </p>
                        <a href="{{ route('student.browse-books') }}" class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            Browse Books
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
