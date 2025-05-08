<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = [
        'studentid',
        'full_name',
        'gradesection',
        'amountdue',
        'balance',
        'status',
        
    ];
    protected static function booted()
    {
        // Set default amount_due and calculate balance on create/update
        static::creating(function ($student) {
            // Set default amount_due if not provided
            $student->amount_due = $student->amount_due ?? 30000.00;
            // Calculate balance
            $student->balance = $student->amount_due - ($student->payment_amount ?? 0.00);
        });

        static::updating(function ($student) {
            // Recalculate balance on update
            $student->balance = $student->amount_due - ($student->payment_amount ?? 0.00);
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Optional: Dynamically calculate balance
    public function getBalanceAttribute()
    {
        return $this->amount_due - $this->payment_amount;
    }
}
