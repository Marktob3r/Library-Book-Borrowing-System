<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Book: {{ $book->title }}</h2>
    </x-slot>

    <div class="py-12" x-data="isbnHandler()" x-init="init('{{ $book->isbn }}')">
        <div class="max-w-2xl mx-auto bg-white p-8 shadow-sm sm:rounded-lg border border-gray-200">
            <form action="{{ route('books.update', $book->id) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="grid gap-6">
                    <div>
                        <x-input-label for="title" value="Book Title" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" maxlength="80" value="{{ old('title', $book->title) }}" required />
                    </div>

                    <div>
                        <x-input-label for="author" value="Author Name" />
                        <x-text-input id="author" name="author" type="text" class="block mt-1 w-full" maxlength="70" value="{{ old('author', $book->author) }}" required />
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label value="ISBN Number" />
                            <div class="flex gap-2">
                                <button type="button" @click="setType('10')" :class="type === '10' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs rounded-full font-bold transition">ISBN-10</button>
                                <button type="button" @click="setType('13')" :class="type === '13' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs rounded-full font-bold transition">ISBN-13</button>
                            </div>
                        </div>
                        
                        <x-text-input 
                            id="isbn" name="isbn" type="text" 
                            class="block mt-1 w-full font-mono" 
                            x-model="formattedIsbn"
                            @input="formatInput"
                            required 
                        />
                    </div>

                    <div>
                        <x-input-label for="total_quantity" value="Total Quantity (1-999)" />
                        <x-text-input id="total_quantity" name="total_quantity" type="number" min="1" max="999" class="block mt-1 w-full" value="{{ old('total_quantity', $book->total_quantity) }}" required />
                        <p class="text-xs text-gray-500 mt-1">Note: Available stock will be adjusted automatically.</p>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a href="{{ route('books.index') }}" class="text-sm text-gray-600 hover:underline">Cancel and go back</a>
                        <x-primary-button>Update Book Details</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function isbnHandler() {
            return {
                type: '13',
                formattedIsbn: '',
                
                init(rawIsbn) {
                    this.type = rawIsbn.length <= 10 ? '10' : '13';
                    this.applyFormatting(rawIsbn);
                },

                setType(newType) {
                    this.type = newType;
                    this.applyFormatting(this.formattedIsbn.replace(/\D/g, ''));
                },

                formatInput(e) {
                    this.applyFormatting(e.target.value.replace(/\D/g, ''));
                },

                applyFormatting(val) {
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