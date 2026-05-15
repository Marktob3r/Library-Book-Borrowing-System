<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowTransaction;
use App\Models\Book;
use App\Models\Student;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $status = $request->input('status');
        $search = $request->input('search');

        $transactions = BorrowTransaction::with(['student', 'book'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('student', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_id_number', 'like', "%{$search}%");
                })->orWhereHas('book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'status', 'search'));
    }

    /**
     * Show the form for creating a new transaction (Borrow Book).
     */
    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $books = Book::where('available_quantity', '>', 0)->orderBy('title')->get();

        return view('admin.transactions.create', compact('students', 'books'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_quantity <= 0) {
            return back()->with('error', 'This book is currently out of stock.');
        }

        // Check if student already has this book
        $existingBorrow = BorrowTransaction::where('student_id', $request->student_id)
            ->where('book_id', $request->book_id)
            ->where('status', 'Borrowed')
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'Student has already borrowed this book and has not returned it yet.');
        }

        BorrowTransaction::create([
            'student_id' => $request->student_id,
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'status' => 'Borrowed',
        ]);

        // Update book availability
        $book->update([
            'available_quantity' => $book->available_quantity - 1,
            'status' => $book->available_quantity - 1 > 0 ? 'Available' : 'Out of Stock',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Book successfully issued to student.');
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook(BorrowTransaction $transaction)
    {
        if ($transaction->status === 'Returned') {
            return back()->with('info', 'This book has already been returned.');
        }

        $transaction->update([
            'returned_at' => now(),
            'status' => 'Returned',
        ]);

        // Restore book availability
        $book = $transaction->book;
        $book->update([
            'available_quantity' => $book->available_quantity + 1,
            'status' => 'Available',
        ]);

        return back()->with('success', 'Book successfully marked as returned.');
    }
}
