<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'book_id',
        'borrowed_at',
        'returned_at',
        'status',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the student associated with this transaction.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the book associated with this transaction.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

