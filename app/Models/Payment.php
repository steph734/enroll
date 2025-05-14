<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'first_name',
        'last_name',
        'grade_level',
        'section_id',
        'amount_due',
        'payment_amount',
        'balance',
        'status',
        'payment_date',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function paymentLines()
    {
        return $this->hasMany(PaymentLine::class, 'payment_id');
    }
}
