<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'studentid',
        'first_name',
        'last_name',
        'grade_level',
        'amount_due',
        'payment_amount',
        'balance',
        'status',
        'payment_date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
