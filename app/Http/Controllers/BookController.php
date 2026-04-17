<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;    

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all(); 
        return view('books.index', compact('books'));
    }  

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn', // Ensures no duplicate ISBNs
            'total_quantity' => 'required|integer|min:1',
        ]);

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
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book removed from inventory successfully.');
    }
}
