<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">Add New Book</h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-white min-h-screen relative overflow-hidden" x-data="isbnHandler()">
        {{-- Decorative background --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-200 rounded-full opacity-[0.25] animate-pulse-soft"></div>
            <div class="absolute bottom-10 -left-12 w-56 h-56 bg-blue-300 rounded-full opacity-[0.25] animate-pulse-soft" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="bg-white p-8 rounded-xl shadow-md border border-blue-50 animate-slide-up">
                {{-- Form header --}}
                <div class="flex items-center gap-3 mb-8 pb-6 border-b border-blue-100">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">New Book Details</h3>
                        <p class="text-sm text-gray-500">Fill in the book information below</p>
                    </div>
                </div>

                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-6">

                        <div>
                            <x-input-label for="title" value="Book Title" />
                            <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" maxlength="80" required placeholder="Don Quixote"/>
                        </div>

                        <div>
                            <x-input-label for="author" value="Author Name" />
                            <x-text-input id="author" name="author" type="text" class="block mt-1 w-full" maxlength="70" required placeholder="Miguel de Cervantes"/>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <div class="flex items-center justify-between mb-2">
                                <x-input-label value="ISBN Number" />
                                <div class="flex gap-2">
                                    <button type="button" @click="setType('10')" :class="type === '10' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50'" class="px-3 py-1 text-xs rounded-full font-bold transition-all duration-200">ISBN-10</button>
                                    <button type="button" @click="setType('13')" :class="type === '13' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50'" class="px-3 py-1 text-xs rounded-full font-bold transition-all duration-200">ISBN-13</button>
                                </div>
                            </div>

                            <x-text-input
                                id="isbn"
                                name="isbn"
                                type="text"
                                class="block mt-1 w-full font-mono"
                                x-model="formattedIsbn"
                                @input="formatInput"
                                required
                            />
                        </div>

                        <div>
                            <x-input-label for="total_quantity" value="Total Quantity (1-999)" />
                            <x-text-input id="total_quantity" name="total_quantity" type="number" min="1" max="999" class="block mt-1 w-full" required placeholder="1"/>
                        </div>

                        <div class="flex items-center justify-between mt-4 pt-6 border-t border-blue-100">
                            <a href="{{ route('books.index') }}" class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center gap-1 group">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                Back to catalog
                            </a>
                            <x-primary-button class="ml-4">
                                Save Book to Inventory
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function isbnHandler() {
            return {
                type: '13',
                formattedIsbn: '',

                setType(newType) {
                    this.type = newType;
                    this.formattedIsbn = '';
                },

                formatInput(e) {
                    let val = e.target.value.replace(/\D/g, '');
                    let limit = this.type === '10' ? 10 : 13;
                    val = val.substring(0, limit);

                    if (this.type === '10') {
                        if (val.length > 1) val = val.slice(0, 1) + '-' + val.slice(1);
                        if (val.length > 5) val = val.slice(0, 5) + '-' + val.slice(5);
                        if (val.length > 11) val = val.slice(0, 11) + '-' + val.slice(11);
                    } else {
                        if (val.length > 3) val = val.slice(0, 3) + '-' + val.slice(3);
                        if (val.length > 5) val = val.slice(0, 5) + '-' + val.slice(5);
                        if (val.length > 8) val = val.slice(0, 8) + '-' + val.slice(8);
                        if (val.length > 15) val = val.slice(0, 15) + '-' + val.slice(15);
                    }

                    this.formattedIsbn = val;
                }
            }
        }
    </script>
</x-app-layout>