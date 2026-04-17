<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Models\BorrowTransaction;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

// KEEP THIS - It handles all 7 CRUD routes including the index with the data
Route::resource('books', BookController::class)->middleware(['auth']);

// DELETE OR COMMENT OUT THE CODE BELOW
// Route::get('/books', function () {
//    return view('books.index');
// })->middleware(['auth', 'verified'])->name('books.index');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'totalBooks' => Book::sum('total_quantity'),
        'availableBooks' => Book::sum('available_quantity'),
        'borrowedBooks' => BorrowTransaction::where('status', 'Borrowed')->count(),
        'recentTransactions' => BorrowTransaction::with(['student', 'book'])->latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';