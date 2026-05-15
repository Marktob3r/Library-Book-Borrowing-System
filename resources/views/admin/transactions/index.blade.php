<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                {{ __('Borrow Transactions') }}
            </h2>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Issue Book
            </a>
        </div>
    </x-slot>

    {{-- Shared confirm modal + page content --}}
    <div x-data="{
            confirmOpen: false,
            confirmMessage: '',
            confirmAction: null,
            ask(message, formId) {
                this.confirmMessage = message;
                this.confirmAction  = formId;
                this.confirmOpen    = true;
            },
            proceed() {
                if (this.confirmAction) document.getElementById(this.confirmAction).submit();
                this.confirmOpen = false;
            }
        }"
        @keydown.escape.window="confirmOpen = false">

        {{-- Custom Confirm Modal --}}
        <div x-show="confirmOpen" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"  x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
             @click.self="confirmOpen = false">
            <div x-show="confirmOpen"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm mx-4 text-center" @click.stop>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Confirm Action</h3>
                <p class="text-sm text-gray-500 mb-6" x-text="confirmMessage"></p>
                <div class="flex justify-center gap-3">
                    <button @click="confirmOpen = false" class="px-5 py-2.5 text-gray-600 font-semibold text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                    <button @click="proceed()" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-bold text-sm hover:bg-blue-700 transition-colors shadow-sm">Confirm</button>
                </div>
            </div>
        </div>

        <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-200 rounded-full opacity-[0.25] animate-pulse-soft"></div>
                <div class="absolute bottom-20 -left-20 w-72 h-72 bg-blue-300 rounded-full opacity-[0.25] animate-pulse-soft" style="animation-delay: 2s;"></div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

                <!-- Filters -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-8 animate-slide-up border border-blue-50">
                    <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="w-full sm:w-1/3">
                            <label for="search" class="block text-sm font-semibold text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Student Name, ID, or Book Title..." class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            </div>
                        </div>
                        <div class="w-full sm:w-1/4">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                                <option value="">All Transactions</option>
                                <option value="Pending"          {{ $status === 'Pending'          ? 'selected' : '' }}>⏳ Pending Approval</option>
                                <option value="Borrowed"         {{ $status === 'Borrowed'         ? 'selected' : '' }}>📖 Currently Borrowed</option>
                                <option value="Return Requested" {{ $status === 'Return Requested' ? 'selected' : '' }}>🔄 Return Requested</option>
                                <option value="Returned"         {{ $status === 'Returned'         ? 'selected' : '' }}>✅ Returned</option>
                                <option value="Rejected"         {{ $status === 'Rejected'         ? 'selected' : '' }}>❌ Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-bold shadow-sm hover:bg-blue-100 transition-colors">Filter</button>
                        @if($search || $status)
                            <a href="{{ route('transactions.index') }}" class="px-6 py-2.5 text-gray-600 hover:text-gray-900 font-semibold transition-colors">Clear Filters</a>
                        @endif
                    </form>
                </div>

                <!-- Transactions Table -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-50 animate-slide-up" style="animation-delay:.1s;">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-blue-50/80 text-gray-700 uppercase text-[11px] font-bold border-b-2 border-blue-100">
                                    <th class="py-4 px-6">Student Info</th>
                                    <th class="py-4 px-6">Book Info</th>
                                    <th class="py-4 px-6">Dates</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($transactions as $transaction)
                                    <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-gray-900">{{ $transaction->student->first_name ?? '—' }} {{ $transaction->student->last_name ?? '' }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">ID: {{ $transaction->student->student_id_number ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-gray-900">{{ $transaction->book->title ?? '—' }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">ISBN: {{ $transaction->book->isbn ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-600 space-y-0.5">
                                            <div>Requested: {{ $transaction->borrowed_at->format('M d, Y h:i A') }}</div>
                                            @if($transaction->approved_at)
                                                <div class="text-blue-600 text-xs">Approved: {{ $transaction->approved_at->format('M d, Y h:i A') }}</div>
                                            @endif
                                            @if($transaction->returned_at)
                                                <div class="text-green-600 text-xs font-semibold">Returned: {{ $transaction->returned_at->format('M d, Y h:i A') }}</div>
                                            @endif
                                            @if($transaction->rejected_reason)
                                                <div class="text-red-500 text-xs italic">{{ $transaction->rejected_reason }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @php
                                                [$badgeClass, $emoji] = match($transaction->status) {
                                                    'Pending'          => ['bg-yellow-100 text-yellow-700 border-yellow-200', '⏳'],
                                                    'Borrowed'         => ['bg-blue-100 text-blue-700 border-blue-200', '📖'],
                                                    'Return Requested' => ['bg-orange-100 text-orange-700 border-orange-200', '🔄'],
                                                    'Returned'         => ['bg-green-100 text-green-700 border-green-200', '✅'],
                                                    'Rejected'         => ['bg-red-100 text-red-700 border-red-200', '❌'],
                                                    default            => ['bg-gray-100 text-gray-700 border-gray-200', '•'],
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $badgeClass }}">
                                                {{ $emoji }} {{ $transaction->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex items-center justify-end gap-2 flex-wrap">

                                                @if($transaction->status === 'Pending')
                                                    {{-- Hidden form for approve --}}
                                                    <form id="approve-{{ $transaction->id }}" action="{{ route('transactions.approve', $transaction) }}" method="POST" class="hidden">@csrf</form>
                                                    <button type="button"
                                                        @click="ask('Approve this request and issue the book to the student?', 'approve-{{ $transaction->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg font-bold text-xs hover:bg-blue-700 transition-colors shadow-sm">
                                                        ✓ Approve
                                                    </button>

                                                    {{-- Reject has its own reason modal --}}
                                                    <div x-data="{ open: false }" class="inline">
                                                        <button type="button" @click="open = true" class="inline-flex items-center px-3 py-1.5 bg-white border-2 border-red-400 text-red-600 rounded-lg font-bold text-xs hover:bg-red-50 transition-colors">
                                                            ✕ Reject
                                                        </button>
                                                        <div x-show="open" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40 backdrop-blur-sm" @click.self="open = false">
                                                            <form action="{{ route('transactions.reject', $transaction) }}" method="POST" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4" @click.stop>
                                                                @csrf
                                                                <h3 class="text-lg font-bold text-gray-900 mb-1">Reject Borrow Request</h3>
                                                                <p class="text-sm text-gray-500 mb-4">For <strong>{{ $transaction->book->title ?? 'this book' }}</strong> by <strong>{{ ($transaction->student->first_name ?? '') . ' ' . ($transaction->student->last_name ?? '') }}</strong>.</p>
                                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Reason (optional)</label>
                                                                <input type="text" name="reason" placeholder="e.g. Book reserved, student has overdue books..." class="w-full rounded-lg border-gray-300 focus:border-red-400 focus:ring-red-400 text-sm mb-4">
                                                                <div class="flex justify-end gap-3">
                                                                    <button type="button" @click="open = false" class="px-4 py-2 text-gray-600 font-semibold text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                                                                    <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg font-bold text-sm hover:bg-red-700 transition-colors">Confirm Reject</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                @elseif($transaction->status === 'Return Requested')
                                                    <form id="confirm-return-{{ $transaction->id }}" action="{{ route('transactions.confirm-return', $transaction) }}" method="POST" class="hidden">@csrf</form>
                                                    <button type="button"
                                                        @click="ask('Confirm that the student has physically returned this book?', 'confirm-return-{{ $transaction->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg font-bold text-xs hover:bg-green-700 transition-colors shadow-sm">
                                                        ✓ Confirm Return
                                                    </button>

                                                @elseif($transaction->status === 'Borrowed')
                                                    <form id="manual-return-{{ $transaction->id }}" action="{{ route('transactions.return', $transaction) }}" method="POST" class="hidden">@csrf</form>
                                                    <button type="button"
                                                        @click="ask('Manually mark this book as returned? This will restore it to inventory.', 'manual-return-{{ $transaction->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 bg-white border-2 border-green-500 text-green-600 rounded-lg font-bold text-xs hover:bg-green-50 transition-colors shadow-sm">
                                                        Mark Returned
                                                    </button>

                                                @else
                                                    <span class="inline-flex items-center px-4 py-1.5 bg-gray-50 border-2 border-gray-200 text-gray-400 rounded-lg font-bold text-xs cursor-not-allowed">No Action</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 px-6 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900">No Transactions Found</h3>
                                                <p class="text-gray-500 text-sm mt-1">There are no transactions matching your current filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 animate-slide-up" style="animation-delay:.2s;">
                    {{ $transactions->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
