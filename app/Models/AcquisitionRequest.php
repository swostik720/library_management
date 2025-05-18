<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcquisitionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'requested_by',
        'status',
        'notes',
    ];

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
