<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

     protected $fillable = [
        'studentid',
        'receiptnumber',
        'amount',
        'payment_method',
        'payment_date',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentid', 'studentid');
    }
   
}
