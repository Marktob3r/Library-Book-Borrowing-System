<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Show available books for borrowing
     */
    public function browseBooks()
    {
        $perPage = request('per_page', 12);
        $search = request('search');
        $sort = request('sort', 'updated_at');
        $direction = request('direction', 'desc');

        $books = Book::query()
            ->where('available_quantity', '>', 0)
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        return view('student.books.browse', compact('books', 'search', 'sort', 'direction', 'perPage'));
    }

    /**
     * Show student dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile');
        }

        $totalBorrowed = BorrowTransaction::where('student_id', $student->id)
            ->where('status', 'Borrowed')
            ->count();

        $totalReturned = BorrowTransaction::where('student_id', $student->id)
            ->where('status', 'Returned')
            ->count();

        $recentTransactions = BorrowTransaction::where('student_id', $student->id)
            ->with('book')
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('student', 'totalBorrowed', 'totalReturned', 'recentTransactions'));
    }

    /**
     * Show borrowing history for student
     */
    public function history()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile');
        }

        $perPage = request('per_page', 10);
        $status = request('status');

        $transactions = BorrowTransaction::where('student_id', $student->id)
            ->with('book')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('student.history', compact('transactions', 'status'));
    }

    /**
     * Borrow a book
     */
    public function borrow(Request $request, $bookId)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile')->with('error', 'Please complete your student profile first.');
        }

        $book = Book::findOrFail($bookId);

        // Check if book is available
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'This book is currently out of stock.');
        }

        // Check if student has already borrowed this book and not returned it
        $existingBorrow = BorrowTransaction::where('student_id', $student->id)
            ->where('book_id', $bookId)
            ->where('status', 'Borrowed')
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'You have already borrowed this book. Please return it before borrowing another copy.');
        }

        // Create the borrow transaction
        BorrowTransaction::create([
            'student_id' => $student->id,
            'book_id' => $bookId,
            'borrowed_at' => now(),
            'status' => 'Borrowed',
        ]);

        // Update book availability
        $book->update([
            'available_quantity' => $book->available_quantity - 1,
            'status' => $book->available_quantity - 1 > 0 ? 'Available' : 'Out of Stock',
        ]);

        return back()->with('success', 'Book borrowed successfully! You can return it anytime.');
    }

    /**
     * Return a book
     */
    public function returnBook(Request $request, $transactionId)
    {
        $transaction = BorrowTransaction::findOrFail($transactionId);
        $user = Auth::user();
        $student = $user->student;

        // Verify the transaction belongs to the student
        if ($transaction->student_id !== $student->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($transaction->status === 'Returned') {
            return back()->with('info', 'This book has already been returned.');
        }

        // Update transaction
        $transaction->update([
            'returned_at' => now(),
            'status' => 'Returned',
        ]);

        // Update book availability
        $book = $transaction->book;
        $book->update([
            'available_quantity' => $book->available_quantity + 1,
            'status' => 'Available',
        ]);

        return back()->with('success', 'Book returned successfully. Thank you!');
    }
}
