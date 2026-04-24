<x-app-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }" x-cloak>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-3xl text-gray-900 leading-tight flex items-center gap-3">
                        {{ __('Book Catalog') }}
                    </h2>
                </div>
            </div>
        </x-slot>

        <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Search & Filter Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-blue-50">
                    <div class="flex flex-col md:flex-row justify-between items-stretch gap-4">
                        <div class="flex flex-col sm:flex-row flex-1 items-center gap-3">
                            <form action="{{ route('books.index') }}" method="GET" class="relative w-full sm:flex-1">
                                <input type="hidden" name="sort" value="{{ $sort }}">
                                <input type="hidden" name="direction" value="{{ $direction }}">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ $search }}"
                                    placeholder="Search by title or author..." 
                                    class="w-full pl-10 pr-4 py-2.5 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all shadow-sm text-sm hover:border-blue-300"
                                >
                                <div class="absolute left-3 top-3 text-blue-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </form>

                            <form action="{{ route('books.index') }}" method="GET" class="flex items-center gap-2">
                                <input type="hidden" name="search" value="{{ $search }}">
                                <input type="hidden" name="sort" value="{{ $sort }}">
                                <input type="hidden" name="direction" value="{{ $direction }}">
                                
                                <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Show</label>
                                <select name="per_page" onchange="this.form.submit()" class="text-sm border-2 border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8 shadow-sm hover:border-blue-300 transition-colors bg-white">
                                    @foreach([15, 25, 50, 100] as $val)
                                        <option value="{{ $val }}" {{ $perPage == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <a href="{{ route('books.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-md transition-all duration-200 transform hover:scale-105 text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Add New Book
                        </a>
                    </div>
                </div>

                <!-- Books Table -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-50">
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 z-20">
                                <tr class= text-gray-700 uppercase text-[11px] font-bold border-b border-blue-200">
                                    <th class="py-3 px-6">
                                        <a href="{{ route('books.index', ['sort' => 'title', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'title' ? 'text-blue-600 font-bold' : '' }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path fill-rule="evenodd" d="M3 7a1 1 0 011-1h12a1 1 0 011 1v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7zm12-1a1 1 0 00-1 1v10H4V7a1 1 0 00-1-1h12z" clip-rule="evenodd"></path></svg>
                                            Title @if($sort == 'title') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6">
                                        <a href="{{ route('books.index', ['sort' => 'author', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'author' ? 'text-blue-600 font-bold' : '' }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-1.429 5.951 1.429a1 1 0 001.169-1.409l-7-14z"></path></svg>
                                            Author @if($sort == 'author') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6 text-center">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                            Stock
                                        </div>
                                    </th>
                                    <th class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            Status
                                        </div>
                                    </th>
                                    <th class="py-3 px-6 text-center">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2V6H6v1z" clip-rule="evenodd"></path></svg>
                                            Modified
                                        </div>
                                    </th>
                                    <th class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-end gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 01.894.553l1.265 2.531a1 1 0 001.854 0l1.265-2.531A1 1 0 0112 2h4a2 2 0 110 4h-.5a1 1 0 00-.933 1.38l.023.046 1.883 3.766a2 2 0 01-1.786 2.953H16a2 2 0 110 4h-.5a1 1 0 00-.933 1.38l.023.046 1.883 3.766a2 2 0 01-1.786 2.953H4a2 2 0 01-2-2V4a2 2 0 012-2h12z" clip-rule="evenodd"></path></svg>
                                            Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100">
                                @forelse($books as $book)
                                    <tr class="hover:bg-blue-50/80 transition-colors duration-150 group">
                                        <td class="py-4 px-6 text-sm font-semibold text-gray-900">{{ $book->title }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-600">{{ $book->author }}</td>
                                        <td class="py-4 px-6 text-sm">
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-500">{{ $book->available_quantity }}</span>
                                                <span class="text-gray-400">/</span>
                                                <span class="text-gray-500">{{ $book->total_quantity }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider gap-1
                                                {{ $book->status == 'Available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                @if($book->status == 'Available')
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                @else
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                @endif
                                                {{ $book->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-gray-600 text-[12px] whitespace-nowrap">
                                            <div class="font-medium text-gray-800">{{ $book->updated_at->format('M d, Y') }}</div>
                                            <div class="text-[11px] text-gray-500">{{ $book->updated_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('books.edit', $book->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-tighter transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                                                    Edit
                                                </a>
                                                <button 
                                                    @click="showDeleteModal = true; deleteUrl = '/books/{{ $book->id }}'"
                                                    class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-tighter transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25c0 5.079 3.855 9.426 8.756 9.426m0-13c5.5 0 10 4.745 10 10.997 0 5.079-3.855 9.426-8.756 9.426m0 0A8.456 8.456 0 0019.756 27.25c5.079 0 8.755-4.347 8.755-9.426"></path>
                                                </svg>
                                                <p class="text-gray-500 font-semibold">No books found</p>
                                                <p class="text-gray-400 text-sm">No books match your search criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($books->hasPages())
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-t border-blue-100">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="showDeleteModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;" 
             x-cloak>
            
            <div class="bg-white rounded-xl p-8 max-w-md w-full shadow-2xl transform transition-all"
                 @click.away="showDeleteModal = false">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-gradient-to-br from-red-100 to-red-50 mb-4">
                        <s="showDeleteModal = false">
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