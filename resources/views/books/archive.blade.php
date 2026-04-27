<x-app-layout>
    <div x-data="{ showDeleteModal: false, showRestoreModal: false, actionUrl: '' }" x-cloak>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-3xl text-gray-900 leading-tight flex items-center gap-3">
                        {{ __('Archived Books') }}
                    </h2>
                </div>
            </div>
        </x-slot>

        <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search & Filter Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-blue-50">
                    <div class="flex flex-col md:flex-row justify-between items-stretch gap-4">
                        <div class="flex flex-col sm:flex-row flex-1 items-center gap-3">
                            <form action="{{ route('books.archive') }}" method="GET" class="relative w-full sm:flex-1">
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

                            <form action="{{ route('books.archive') }}" method="GET" class="flex items-center gap-2">
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
                    </div>
                </div>

                <!-- Books Table -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-50">
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 z-20">
                                <tr class="bg-blue-50 text-gray-700 uppercase text-[11px] font-bold border-b border-blue-200">
                                    <th class="py-3 px-6">
                                        <a href="{{ route('books.archive', ['sort' => 'title', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'title' ? 'text-blue-600 font-bold' : '' }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960"><path d="M144-288v-72h528v72H144Zm0-156v-72h528v72H144Zm0-156v-72h528v72H144Zm635.5 312q-14.5 0-25-10.35T744-324q0-14 10.35-25T780-360q14 0 25 11t11 25.5q0 14.5-11 25T779.5-288Zm0-156q-14.5 0-25-10.35T744-480q0-14 10.35-25T780-516q14 0 25 11t11 25.5q0 14.5-11 25T779.5-444Zm0-156q-14.5 0-25-10.35T744-636q0-14 10.35-25T780-672q14 0 25 11t11 25.5q0 14.5-11 25T779.5-600Z"/></svg>
                                            Title @if($sort == 'title') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6">
                                        <a href="{{ route('books.archive', ['sort' => 'author', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'author' ? 'text-blue-600 font-bold' : '' }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960"><path d="M576-144v-113l210-209q7-7 16-10.5t18-3.5q9 0 18 3.5t16 10.5l44 45q7 7 10.5 16t3.5 18q0 9-3.5 18T898-353L689-144H576Zm-384-48v-96q0-23 12.5-43.5T239-366q55-32 116.5-49T480-432q38 0 74.5 6t71.5 17L504-287v95H192Zm627-149 45-46-45-45-45 46 45 45ZM378-522q-42-42-42-102t42-102q42-42 102-42t102 42q42 42 42 102t-42 102q-42 42-102 42t-102-42Z"/></svg>
                                            Author @if($sort == 'author') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6 text-center">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960"><path d="M96-192v-72h768v72H96Zm120-144v-288h72v288h-72Zm144 0v-432h72v432h-72Zm144 0v-432h72v432h-72Zm224 0L624-597l67-27 104 261-67 27Z"/></svg>
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
                                        <a href="{{ route('books.archive', ['sort' => 'deleted_at', 'direction' => $direction == 'asc' ? 'desc' : 'asc', 'search' => $search, 'per_page' => $perPage]) }}" class="flex justify-center items-center gap-1 hover:text-blue-600 transition-colors {{ $sort == 'deleted_at' ? 'text-blue-600 font-bold' : '' }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960"><path d="m96-192 384-576 384 576H96Z"/></svg>
                                            Archived On @if($sort == 'deleted_at') {{ $direction == 'asc' ? '↑' : '↓' }} @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-end gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960"><path d="M263.79-408Q234-408 213-429.21t-21-51Q192-510 213.21-531t51-21Q294-552 315-530.79t21 51Q336-450 314.79-429t-51 21Zm216 0Q450-408 429-429.21t-21-51Q408-510 429.21-531t51-21Q510-552 531-530.79t21 51Q552-450 530.79-429t-51 21Zm216 0Q666-408 645-429.21t-21-51Q624-510 645.21-531t51-21Q726-552 747-530.79t21 51Q768-450 746.79-429t-51 21Z"/></svg>
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
                                        <td class="py-4 px-6 text-sm text-center">
                                            <div class="flex items-center justify-center gap-2">
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
                                        <td class="py-4 px-6 text-center text-gray-600 text-[12px] whitespace-nowrap">
                                            <div class="font-medium text-gray-800">{{ $book->deleted_at->format('M d, Y') }}</div>
                                            <div class="text-[11px] text-gray-500">{{ $book->deleted_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex justify-end">
                                                <button 
                                                    @click="showRestoreModal = true; actionUrl = '/books/{{ $book->id }}/restore'"
                                                    class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 hover:bg-green-50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-tighter transition-colors duration-200" title="Restore Book">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                    
                                                </button>
                                                <button 
                                                    @click="showDeleteModal = true; actionUrl = '/books/{{ $book->id }}/force-delete'"
                                                    class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-tighter transition-colors duration-200" title="Delete Permanently">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg>
                                                    
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="currentColor" stroke="currentColor" viewBox="0 -960 960 960">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M480-160q-48-38-104-59t-116-21q-42 0-82.5 11T100-198q-21 11-40.5-1T40-234v-482q0-11 5.5-21T62-752q6-3 11.5-6t11.5-5l-59-59 56-56L878-82l-56 56-204-204q-38 10-72.5 27.5T480-160Zm-80-135v-153L146-702q-7 2-13 4.5t-13 5.5v397q35-13 69.5-19t70.5-6q36 0 70.5 6t69.5 19Zm80-299L274-800q54 2 106 16.5T480-740v146Zm0 338q18-11 36.5-20t38.5-17l-75-75v112Zm161-177-81-81v-226l200-200v400L641-433Zm240 240L758-316q21 3 41.5 8t40.5 12v-480q15 5 29.5 11t28.5 13q11 5 16.5 15t5.5 21v482q0 17-11.5 28.5T881-193ZM400-295v-153 153Z"></path>
                                                </svg>
                                                <p class="text-gray-500 font-semibold">No archived books found</p>
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

        <!-- Restore Modal -->
        <div x-show="showRestoreModal" 
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
                 @click.away="showRestoreModal = false">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-gradient-to-br from-green-100 to-green-50 mb-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Restore Book?</h3>
                    <p class="text-gray-500 mb-8">This book will be moved back to the active catalog.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row-reverse gap-3">
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm font-bold transition">
                            Confirm Restore
                        </button>
                    </form>
                    <button @click="showRestoreModal = false" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Permanently Delete Modal -->
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
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 17c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Permanently?</h3>
                    <p class="text-gray-500 mb-8">This action is permanent and cannot be reversed. The book will be completely erased from the database.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row-reverse gap-3">
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm font-bold transition">
                            Delete Permanently
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
