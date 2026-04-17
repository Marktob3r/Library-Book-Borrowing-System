<x-app-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }" x-cloak>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Book Catalog') }}
                </h2>
                <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm hover:shadow-md">
                    + Add New Book
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <table class="w-full text-left border-collapse">
                        @if($books->isNotEmpty())
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-bold border-b">
                                <th class="py-4 px-6">
                                    <a href="{{ route('books.index', ['sort' => 'title', 'direction' => $direction == 'asc' ? 'desc' : 'asc']) }}" class="hover:text-blue-600">
                                        Title @if($sort == 'title') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th class="py-4 px-6">
                                    <a href="{{ route('books.index', ['sort' => 'author', 'direction' => $direction == 'asc' ? 'desc' : 'asc']) }}" class="hover:text-blue-600">
                                        Author @if($sort == 'author') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th class="py-4 px-6">Stock</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6">Modified</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        @endif
                        <tbody>
                            @forelse($books as $book)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $book->title }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $book->author }}</td>
                                    <td class="py-4 px-6 text-gray-600">
                                        <span class="font-bold">{{ $book->available_quantity }}</span> / {{ $book->total_quantity }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold 
                                            {{ $book->status == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $book->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500 text-sm">
                                        {{ $book->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-3">
                                        <a href="{{ route('books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">Edit</a>
                                        <button 
                                            @click="showDeleteModal = true; deleteUrl = '/books/{{ $book->id }}'"
                                            class="text-red-600 hover:text-red-900 text-sm font-semibold">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-20">
                                        <div class="flex flex-col items-center justify-center text-center">
                                            <div class="bg-gray-100 p-6 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900">No books in the library</h3>
                                            <p class="text-gray-500 max-w-xs mt-2">Your collection is currently empty. Start by adding your first book to the inventory.</p>
                                            <div class="mt-6">
                                                <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                    Get Started
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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