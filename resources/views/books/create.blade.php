<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Add New Book to Inventory</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 shadow-sm sm:rounded-lg">
            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <div class="grid gap-4">
                    <div>
                        <x-input-label for="title" value="Book Title" />
                        <x-text-input id="title" name="title" class="block mt-1 w-full" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="author" value="Author" />
                            <x-text-input id="author" name="author" class="block mt-1 w-full" required />
                        </div>
                        <div>
                            <x-input-label for="isbn" value="ISBN" />
                            <x-text-input id="isbn" name="isbn" class="block mt-1 w-full" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="total_quantity" value="Total Quantity" />
                        <x-text-input id="total_quantity" type="number" name="total_quantity" class="block mt-1 w-full" required />
                    </div>
                    <x-primary-button class="justify-center">Save Book</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>