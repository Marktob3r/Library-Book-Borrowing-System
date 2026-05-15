<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return redirect()->route('login');
});

// ADMIN ROUTES (Book Management)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/books/archive', [BookController::class, 'archive'])->name('books.archive');
    Route::post('/books/{id}/restore', [BookController::class, 'restore'])->name('books.restore');
    Route::delete('/books/{id}/force-delete', [BookController::class, 'forceDelete'])->name('books.forceDelete');
    
    Route::resource('books', BookController::class);
    
    Route::resource('transactions', App\Http\Controllers\TransactionController::class)->only(['index', 'create', 'store']);
    Route::post('/transactions/{transaction}/approve', [App\Http\Controllers\TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [App\Http\Controllers\TransactionController::class, 'reject'])->name('transactions.reject');
    Route::post('/transactions/{transaction}/confirm-return', [App\Http\Controllers\TransactionController::class, 'confirmReturn'])->name('transactions.confirm-return');
    Route::post('/transactions/{transaction}/return', [App\Http\Controllers\TransactionController::class, 'returnBook'])->name('transactions.return');

    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalBooks'         => Book::sum('total_quantity'),
            'availableBooks'     => Book::sum('available_quantity'),
            'borrowedBooks'      => BorrowTransaction::where('status', 'Borrowed')->count(),
            'pendingRequests'    => BorrowTransaction::where('status', 'Pending')->count(),
            'returnRequests'     => BorrowTransaction::where('status', 'Return Requested')->count(),
            'recentTransactions' => BorrowTransaction::with(['student', 'book'])->latest()->take(5)->get(),
        ]);
    })->name('dashboard');
});

// STUDENT ROUTES (Book Browsing & Borrowing)
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/browse-books', [StudentController::class, 'browseBooks'])->name('student.browse-books');
    Route::get('/student/history', [StudentController::class, 'history'])->name('student.history');
    Route::post('/student/borrow/{bookId}', [StudentController::class, 'borrow'])->name('student.borrow');
    Route::post('/student/return/{transactionId}', [StudentController::class, 'returnBook'])->name('student.return-book');
});

// SHARED ROUTES (Auth & Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';