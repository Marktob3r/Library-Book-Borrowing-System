<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

class Book extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'total_quantity',
        'available_quantity',
        'status',
    ];

    public function prunable()
    {
        return static::onlyTrashed()->where('deleted_at', '<=', now()->subDays(30));
    }

    /**
     * Get all borrow transactions for this book.
     */
    public function borrowTransactions()
    {
        return $this->hasMany(BorrowTransaction::class);
    }
}