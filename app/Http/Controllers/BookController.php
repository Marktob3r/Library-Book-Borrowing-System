<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;    

class BookController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search');
        $sort = request('sort', 'updated_at');
        $direction = request('direction', 'desc');

        $books = Book::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        return view('books.index', compact('books', 'search', 'sort', 'direction', 'perPage'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:80', // Limit 80
            'author' => 'required|string|max:70', // Limit 70
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'total_quantity' => 'required|integer|min:1|max:999', // Min 1, Max 999
        ]);

        // 2. Clean the ISBN (remove dashes) before saving to DB
        $validated['isbn'] = str_replace('-', '', $request->isbn);

        $validated['available_quantity'] = $validated['total_quantity'];
        $validated['status'] = 'Available';

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:80',
            'author' => 'required|string|max:70',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'total_quantity' => 'required|integer|min:1|max:999',
        ]);

        $validated['isbn'] = str_replace('-', '', $request->isbn);

        $quantityDifference = $validated['total_quantity'] - $book->total_quantity;
        $validated['available_quantity'] = $book->available_quantity + $quantityDifference;

        if ($validated['available_quantity'] < 0) {
            return back()->withErrors(['total_quantity' => 'Total quantity cannot be less than currently borrowed books.']);
        }

        $validated['status'] = $validated['available_quantity'] > 0 ? 'Available' : 'Out of Stock';

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book archived successfully. It will be permanently deleted after 30 days.');
    }

    public function archive()
    {
        $perPage = request('per_page', 15);
        $search = request('search');
        $sort = request('sort', 'deleted_at');
        $direction = request('direction', 'desc');

        $books = Book::onlyTrashed()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        return view('books.archive', compact('books', 'search', 'sort', 'direction', 'perPage'));
    }

    public function restore(string $id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();

        return redirect()->route('books.archive')->with('success', 'Book restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->forceDelete();

        return redirect()->route('books.archive')->with('success', 'Book permanently deleted.');
    }
}
