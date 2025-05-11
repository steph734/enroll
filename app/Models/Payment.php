<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
      'studentid',
        'payment_date',
        'downpayment',
        'payment_method',
        'balance',
        'receiptnumber',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
