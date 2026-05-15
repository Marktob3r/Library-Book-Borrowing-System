<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowTransaction;
use App\Models\Book;
use App\Models\Student;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $status  = $request->input('status');
        $search  = $request->input('search');

        $transactions = BorrowTransaction::with(['student', 'book'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('student', fn($s) => $s
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('student_id_number', 'like', "%{$search}%")
                )->orWhereHas('book', fn($b) => $b
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                );
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'status', 'search'));
    }

    /**
     * Show the manual issue form (admin-initiated borrow, bypasses pending).
     */
    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $books    = Book::where('available_quantity', '>', 0)->orderBy('title')->get();

        return view('admin.transactions.create', compact('students', 'books'));
    }

    /**
     * Admin manually issues a book (instantly Borrowed, no pending step).
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'book_id'    => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_quantity <= 0) {
            return back()->with('error', 'This book is currently out of stock.');
        }

        $existingBorrow = BorrowTransaction::where('student_id', $request->student_id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['Pending', 'Borrowed', 'Return Requested'])
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'Student already has an active or pending request for this book.');
        }

        BorrowTransaction::create([
            'student_id'  => $request->student_id,
            'book_id'     => $request->book_id,
            'borrowed_at' => now(),
            'approved_at' => now(),
            'status'      => 'Borrowed',
        ]);

        $book->decrement('available_quantity');
        if ($book->fresh()->available_quantity <= 0) {
            $book->update(['status' => 'Out of Stock']);
        }

        return redirect()->route('transactions.index')->with('success', 'Book successfully issued to student.');
    }

    /**
     * Admin approves a student's Pending borrow request.
     */
    public function approve(BorrowTransaction $transaction)
    {
        if ($transaction->status !== 'Pending') {
            return back()->with('error', 'This request is no longer pending.');
        }

        $book = $transaction->book;

        if ($book->available_quantity <= 0) {
            $transaction->update(['status' => 'Rejected', 'rejected_reason' => 'Book went out of stock.']);
            return back()->with('error', 'Cannot approve — book is out of stock. Request has been auto-rejected.');
        }

        $transaction->update([
            'status'      => 'Borrowed',
            'approved_at' => now(),
            'borrowed_at' => now(),
        ]);

        $book->decrement('available_quantity');
        if ($book->fresh()->available_quantity <= 0) {
            $book->update(['status' => 'Out of Stock']);
        }

        return back()->with('success', 'Borrow request approved. Book has been issued to the student.');
    }

    /**
     * Admin rejects a student's Pending borrow request.
     */
    public function reject(Request $request, BorrowTransaction $transaction)
    {
        if ($transaction->status !== 'Pending') {
            return back()->with('error', 'This request is no longer pending.');
        }

        $transaction->update([
            'status'          => 'Rejected',
            'rejected_reason' => $request->input('reason', 'Request rejected by librarian.'),
        ]);

        return back()->with('success', 'Borrow request has been rejected.');
    }

    /**
     * Admin confirms physical book has been returned (Return Requested → Returned).
     */
    public function confirmReturn(BorrowTransaction $transaction)
    {
        if ($transaction->status !== 'Return Requested') {
            return back()->with('error', 'This book is not in a return-requested state.');
        }

        $transaction->update([
            'returned_at' => now(),
            'status'      => 'Returned',
        ]);

        $book = $transaction->book;
        $book->increment('available_quantity');
        $book->update(['status' => 'Available']);

        return back()->with('success', 'Return confirmed. Book inventory has been updated.');
    }

    /**
     * Admin directly marks a Borrowed/Return Requested book as Returned (manual override).
     */
    public function returnBook(BorrowTransaction $transaction)
    {
        if ($transaction->status === 'Returned') {
            return back()->with('info', 'This book has already been returned.');
        }

        $previousStatus = $transaction->status;

        $transaction->update([
            'returned_at' => now(),
            'status'      => 'Returned',
        ]);

        $book = $transaction->book;
        if (in_array($previousStatus, ['Borrowed', 'Return Requested'])) {
            $book->increment('available_quantity');
            $book->update(['status' => 'Available']);
        }

        return back()->with('success', 'Book successfully marked as returned.');
    }
}
