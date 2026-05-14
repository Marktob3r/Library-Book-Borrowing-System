<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Student Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden">
        {{-- Decorative background shapes --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-200 rounded-full opacity-10 animate-pulse-soft"></div>
            <div class="absolute bottom-20 -left-20 w-72 h-72 bg-blue-300 rounded-full opacity-10 animate-pulse-soft" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 right-[5%] animate-float-slow opacity-[0.04]">
                <svg class="w-28 h-28 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                </svg>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-md p-8 mb-8 text-white animate-fade-in relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-400 rounded-full opacity-15 -mr-16 -mt-16 animate-pulse-soft"></div>
                <div class="absolute bottom-0 left-1/2 w-24 h-24 bg-blue-300 rounded-full opacity-10 -mb-12"></div>
                <div class="relative">
                    <h1 class="text-3xl font-bold mb-1">Welcome, {{ $student->first_name }}!</h1>
                    <p class="text-blue-100 text-sm">{{ $student->course }} — Year {{ $student->year_level }} | Block {{ $student->block }} | ID: {{ $student->student_id_number }}</p>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 stagger">

                {{-- Currently Borrowed --}}
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 animate-slide-up">
                    <div class="relative p-8 bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-400 rounded-full opacity-20 -mr-10 -mt-10 animate-pulse-soft"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-blue-300 rounded-full opacity-10 -ml-6 -mb-6"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-semibold mb-2">Currently Borrowed</p>
                                    <p class="text-white text-4xl font-bold animate-count-pop">{{ $totalBorrowed }}</p>
                                </div>
                                <svg class="w-12 h-12 text-blue-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <p class="text-blue-100 text-xs mt-4">Books checked out</p>
                        </div>
                    </div>
                </div>

                {{-- Books Returned --}}
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 animate-slide-up">
                    <div class="relative p-8 bg-gradient-to-br from-green-500 to-green-600 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-400 rounded-full opacity-20 -mr-10 -mt-10 animate-pulse-soft"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-300 rounded-full opacity-10 -ml-6 -mb-6"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-semibold mb-2">Books Returned</p>
                                    <p class="text-white text-4xl font-bold animate-count-pop" style="animation-delay: .1s;">{{ $totalReturned }}</p>
                                </div>
                                <svg class="w-12 h-12 text-green-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-green-100 text-xs mt-4">Successfully returned</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Action --}}
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 animate-slide-up">
                    <div class="relative p-8 bg-gradient-to-br from-amber-500 to-amber-600 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-400 rounded-full opacity-20 -mr-10 -mt-10 animate-pulse-soft"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-amber-300 rounded-full opacity-10 -ml-6 -mb-6"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-amber-100 text-sm font-semibold mb-2">Browse Library</p>
                                    <a href="{{ route('student.browse-books') }}"
                                       class="inline-block mt-1 px-5 py-2 bg-white text-amber-600 font-bold rounded-lg text-sm hover:bg-amber-50 transition-all shadow group">
                                        Browse Books
                                        <svg class="w-4 h-4 inline ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                                <svg class="w-12 h-12 text-amber-300 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                                </svg>
                            </div>
                            <p class="text-amber-100 text-xs mt-4">Find your next read</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Borrowing Activity --}}
            <div class="bg-white overflow-hidden rounded-xl shadow-md animate-slide-up" style="animation-delay: .3s;">
                <div class="px-8 py-6 border-b-2 border-blue-100 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                                    <path fill-rule="evenodd" d="M3 9a1 1 0 011-1h12a1 1 0 011 1v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Recent Borrowing Activity</h3>
                                <p class="text-sm text-gray-500">Your latest transactions</p>
                            </div>
                        </div>
                        <a href="{{ route('student.history') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-2 transition group">
                            View All
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-8">
                    @if($recentTransactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-blue-50 text-gray-700 uppercase text-[11px] font-bold border-b border-blue-200">
                                        <th class="py-3 px-6">Book Title</th>
                                        <th class="py-3 px-6">Author</th>
                                        <th class="py-3 px-6">Borrowed Date</th>
                                        <th class="py-3 px-6 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-blue-100">
                                    @foreach($recentTransactions as $transaction)
                                        <tr class="hover:bg-blue-50/80 transition-colors duration-150">
                                            <td class="py-4 px-6 text-sm font-semibold text-gray-900">{{ $transaction->book->title }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->book->author }}</td>
                                            <td class="py-4 px-6 text-sm text-gray-600">{{ $transaction->borrowed_at->format('M d, Y') }}</td>
                                            <td class="py-4 px-6 text-center">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                    {{ $transaction->status === 'Borrowed' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                                    {{ $transaction->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12">
                            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-center">
                                <span class="font-semibold">No transactions yet</span><br>
                                <span class="text-sm">Borrow transactions will appear here</span>
                            </p>
                            <a href="{{ route('student.browse-books') }}" class="mt-4 px-5 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-semibold rounded-lg transition-all shadow-md">
                                Start Browsing Books
                            </a>
                        </div>
                    @endif
                </div>
            </div>

</x-app-layout>
