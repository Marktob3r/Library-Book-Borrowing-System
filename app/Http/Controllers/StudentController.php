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
     * Request to borrow a book (creates a Pending transaction)
     */
    public function borrow(Request $request, $bookId)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile')->with('error', 'Please complete your student profile first.');
        }

        $book = Book::findOrFail($bookId);

        // Check if book has copies at all
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'This book is currently out of stock.');
        }

        // Check if student already has an active or pending borrow for this book
        $existingActive = BorrowTransaction::where('student_id', $student->id)
            ->where('book_id', $bookId)
            ->whereIn('status', ['Pending', 'Borrowed', 'Return Requested'])
            ->exists();

        if ($existingActive) {
            return back()->with('error', 'You already have an active or pending request for this book.');
        }

        // Create a PENDING borrow request — admin must approve
        BorrowTransaction::create([
            'student_id' => $student->id,
            'book_id'    => $bookId,
            'borrowed_at' => now(),
            'status'     => 'Pending',
        ]);

        return back()->with('success', 'Borrow request submitted! Please wait for librarian approval.');
    }

    /**
     * Request to return a book (changes status to Return Requested)
     */
    public function returnBook(Request $request, $transactionId)
    {
        $transaction = BorrowTransaction::findOrFail($transactionId);
        $user = Auth::user();
        $student = $user->student;

        if ($transaction->student_id !== $student->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($transaction->status !== 'Borrowed') {
            return back()->with('info', 'This transaction cannot be returned at this time.');
        }

        // Mark as Return Requested — admin must confirm physical return
        $transaction->update(['status' => 'Return Requested']);

        return back()->with('success', 'Return request submitted! The librarian will confirm once you hand the book back.');
    }
}
