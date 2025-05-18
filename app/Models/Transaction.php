<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'issue_date',
        'due_date',
        'return_date',
        'fine',
        'status',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function calculateFine()
    {
        if ($this->return_date === null && Carbon::now()->gt($this->due_date)) {
            $daysOverdue = Carbon::now()->diffInDays($this->due_date);
            return $daysOverdue * 5; // $5 per day
        } elseif ($this->return_date !== null && $this->return_date->gt($this->due_date)) {
            $daysOverdue = $this->return_date->diffInDays($this->due_date);
            return $daysOverdue * 5; // $5 per day
        }

        return 0;
    }

    public function isOverdue()
    {
        return $this->return_date === null && Carbon::now()->gt($this->due_date);
    }
}
