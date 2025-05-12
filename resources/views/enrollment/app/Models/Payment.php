<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'payment_method',
        'reference_number',
        'payment_date',
        'remarks',
        'processed_by'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
} 