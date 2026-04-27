<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Browse Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="mb-6">
                <form method="GET" class="flex gap-4 flex-wrap">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by title or author..." 
                        value="{{ request('search') }}"
                        class="flex-1 min-w-64 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <select name="sort" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                        <option value="updated_at" {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Latest</option>
                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title (A-Z)</option>
                        <option value="author" {{ request('sort') === 'author' ? 'selected' : '' }}>Author (A-Z)</option>
                    </select>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Search
                    </button>
                </form>
            </div>

            @if($books->count() > 0)
                <!-- Books Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($books as $book)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Book Cover Placeholder -->
                            <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 flex items-center justify-center">
                                <svg class="w-20 h-20 text-blue-500 dark:text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"></path>
                                </svg>
                            </div>

                            <!-- Book Details -->
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-1 line-clamp-2">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    by {{ $book->author }}
                                </p>

                                <!-- Book Info -->
                                <div class="mb-3 text-xs text-gray-500 dark:text-gray-400">
                                    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                    <p><strong>Available:</strong> {{ $book->available_quantity }} / {{ $book->total_quantity }}</p>
                                </div>

                                <!-- Availability Badge -->
                                <div class="mb-4">
                                    @if($book->available_quantity > 0)
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs font-semibold rounded-full">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 text-xs font-semibold rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                @if($book->available_quantity > 0)
                                    <form action="{{ route('student.borrow', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition">
                                            Borrow This Book
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-2 rounded-lg font-medium cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $books->links() }}
                </div>
            @else
                <!-- No Books Found -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        @if(request('search'))
                            No books found matching "{{ request('search') }}"
                        @else
                            No available books at the moment
                        @endif
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        @if(request('search'))
                            Try a different search term
                        @else
                            Please check back later
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
