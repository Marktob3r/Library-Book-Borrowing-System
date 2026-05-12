<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Browse Books') }}
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

            {{-- Search & Filter --}}
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-blue-50 animate-fade-in">
                <form method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search by title or author..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all shadow-sm text-sm hover:border-blue-300"
                        >
                        <div class="absolute left-3 top-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <select name="sort" class="text-sm border-2 border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2.5 pl-3 pr-8 shadow-sm hover:border-blue-300 transition-colors bg-white">
                        <option value="updated_at" {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Latest</option>
                        <option value="title"      {{ request('sort') === 'title'      ? 'selected' : '' }}>Title (A–Z)</option>
                        <option value="author"     {{ request('sort') === 'author'     ? 'selected' : '' }}>Author (A–Z)</option>
                    </select>
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-md transition-all duration-200 text-sm">
                        Search
                    </button>
                </form>
            </div>

            @if($books->count() > 0)
                {{-- Books Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 stagger">
                    @foreach($books as $book)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-blue-50 transform hover:scale-[1.02] hover:-translate-y-1 animate-slide-up">
                            {{-- Book Cover --}}
                            <div class="h-44 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-300 rounded-full opacity-20 -mr-8 -mt-8"></div>
                                <div class="absolute bottom-0 left-0 w-16 h-16 bg-blue-200 rounded-full opacity-15 -ml-6 -mb-6"></div>
                                <svg class="w-20 h-20 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                                </svg>
                            </div>

                            {{-- Book Details --}}
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 mb-1 line-clamp-2">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500 mb-3">by {{ $book->author }}</p>

                                <div class="text-xs text-gray-400 space-y-0.5 mb-4">
                                    <p><span class="font-semibold text-gray-500">ISBN:</span> {{ $book->isbn }}</p>
                                    <p><span class="font-semibold text-gray-500">Available:</span> {{ $book->available_quantity }} / {{ $book->total_quantity }}</p>
                                </div>

                                {{-- Status Badge --}}
                                <div class="mb-4">
                                    @if($book->available_quantity > 0)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                {{-- Action --}}
                                @if($book->available_quantity > 0)
                                    <form action="{{ route('student.borrow', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2.5 rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm hover:shadow-md">
                                            Borrow This Book
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-100 text-gray-400 py-2.5 rounded-lg font-semibold text-sm cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center animate-fade-in">
                    {{ $books->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md p-16 text-center border border-blue-50 animate-fade-in">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                        @if(request('search'))
                            No books found for "{{ request('search') }}"
                        @else
                            No available books at the moment
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm">
                        @if(request('search'))
                            Try a different search term.
                        @else
                            Please check back later.
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
