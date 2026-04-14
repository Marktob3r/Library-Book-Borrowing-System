<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Book Catalog') }}
            </h2>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Add New Book
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm border-b">
                            <th class="py-3 px-4">Title</th>
                            <th class="py-3 px-4">Author</th>
                            <th class="py-3 px-4">ISBN</th>
                            <th class="py-3 px-4">Available / Total</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900">The Pragmatic Programmer</td>
                            <td class="py-3 px-4 text-gray-600">Andrew Hunt</td>
                            <td class="py-3 px-4 text-gray-600">978-0135957059</td>
                            <td class="py-3 px-4 text-gray-600">3 / 5</td>
                            <td class="py-3 px-4">
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Available</span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>