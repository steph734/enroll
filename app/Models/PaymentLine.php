<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLine extends Model
{
    use HasFactory;

    protected $table = 'paymentline';

    protected $fillable = [
        'student_id',
        'payment_id',
        'amount',
        'payment_method',
        'description',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
