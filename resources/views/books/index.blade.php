<x-app-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }" x-cloak>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Book Catalog') }}
                </h2>
            </div>
        </x-slot>
        <div class="py-7">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <div class="flex flex-1 items-center gap-3 w-full md:w-auto">
                        <form action="{{ route('books.index') }}" method="GET" class="relative w-full md:w-80">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}"
                                placeholder="Search by title or author..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all shadow-sm text-sm"
                            >
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>

                        <form action="{{ route('books.index') }}" method="GET" class="flex items-center gap-2">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                            
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Show</label>
                            <select name="per_page" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 py-1.5 pl-3 pr-8 shadow-sm">
                                @foreach([15, 25, 50, 100] as $val)
                                    <option value="{{ $val }}" {{ $perPage == $val ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow-md transition-all text-sm">
                        + Add New Book
                    </a>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 z-20">
                                <tr class="bg-gray-50 text-gray-600 uppercase text-[11px] font-bold border-b border-gray-200">
                                    <th class="py-3 px-6 bg-gray-50">
                                        <a href="{{ route('books.index', ['sort' => 'title', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'title' ? 'text-blue-600' : '' }}">
                                            Title @if($sort == 'title') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6 bg-gray-50">
                                        <a href="{{ route('books.index', ['sort' => 'author', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'author' ? 'text-blue-600' : '' }}">
                                            Author @if($sort == 'author') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6 bg-gray-50">Stock</th>
                                    <th class="py-3 px-6 bg-gray-50 text-center">Status</th>
                                    <th class="py-3 px-6 bg-gray-50">Modified</th>
                                    <th class="py-3 px-6 bg-gray-50 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($books as $book)
                                    <tr class="hover:bg-blue-50/40 transition-colors group">
                                        <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $book->title }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-600">{{ $book->author }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-600">
                                            <span class="font-bold text-gray-800">{{ $book->available_quantity }}</span> / <span class="text-gray-400">{{ $book->total_quantity }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                {{ $book->status == 'Available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $book->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-gray-400 text-[12px] whitespace-nowrap">
                                            {{ $book->updated_at->format('M d, Y') }}<br>
                                            <span class="text-[10px]">{{ $book->updated_at->format('h:i A') }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-right space-x-2">
                                            <a href="{{ route('books.edit', $book->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase tracking-tighter">Edit</a>
                                            <button 
                                                @click="showDeleteModal = true; deleteUrl = '/books/{{ $book->id }}'"
                                                class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-tighter">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-400 italic">
                                            No books found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($books->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             style="display: none;" 
             x-cloak>
            
            <div class="bg-white rounded-xl p-8 max-w-md w-full shadow-2xl transform transition-all"
                 @click.away="showDeleteModal = false">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 17c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Book Record?</h3>
                    <p class="text-gray-500 mb-8">This action is permanent and cannot be reversed. The book will be removed from all records.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row-reverse gap-3">
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm font-bold transition">
                            Confirm Delete
                        </button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style> [x-cloak] { display: none !important; } </style>
</x-app-layout>