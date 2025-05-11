<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'studentid',
        'payment_date',
        'payment_amount',
        'description',
        'payment_method',
        'receiptnumber',
        'paymentstatus',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
