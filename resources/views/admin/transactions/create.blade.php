<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight flex items-center gap-3">
                <a href="{{ route('transactions.index') }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                {{ __('Issue Book to Student') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden">
        {{-- Decorative background shapes --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-200 rounded-full opacity-10 animate-pulse-soft"></div>
            <div class="absolute bottom-20 -left-20 w-72 h-72 bg-blue-300 rounded-full opacity-10 animate-pulse-soft" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-blue-50 animate-slide-up">
                <div class="p-8 sm:p-12">
                    <div class="mb-8 border-b border-gray-100 pb-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Manual Borrowing Form</h3>
                            <p class="text-sm text-gray-500">Record a physical book checkout.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
                        @csrf

                        <!-- Student Selection -->
                        <div>
                            <label for="student_id" class="block text-sm font-bold text-gray-700 mb-2">Select Student</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <select id="student_id" name="student_id" required class="pl-10 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors py-3">
                                    <option value="" disabled selected>-- Choose a student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->last_name }}, {{ $student->first_name }} ({{ $student->student_id_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                        </div>

                        <!-- Book Selection -->
                        <div>
                            <label for="book_id" class="block text-sm font-bold text-gray-700 mb-2">Select Book</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <select id="book_id" name="book_id" required class="pl-10 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors py-3">
                                    <option value="" disabled selected>-- Choose a book --</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} - By {{ $book->author }} ({{ $book->available_quantity }} available)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('book_id')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-2">Only books with available copies are shown.</p>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                            <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Issue Book to Student
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
