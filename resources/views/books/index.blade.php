<x-app-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }" x-cloak>
        
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Book Catalog') }}
                </h2>
                <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                    + Add New Book
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-bold border-b">
                                <th class="py-4 px-6">Title</th>
                                <th class="py-4 px-6">Author</th>
                                <th class="py-4 px-6">Stock</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $book->title }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $book->author }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $book->available_quantity }} / {{ $book->total_quantity }}</td>
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
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" 
             style="display: none;" 
             x-show.important="showDeleteModal">
            
            <div class="bg-white rounded-lg p-8 max-w-md w-full shadow-2xl">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Confirm Deletion</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this book? This action is permanent.</p>
                
                <div class="flex justify-end space-x-4">
                    <button @click="showDeleteModal = false" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                        Cancel
                    </button>
                    
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow-sm font-bold">
                            Yes, Delete Book
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style> [x-cloak] { display: none !important; } </style>
</x-app-layout>