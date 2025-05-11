<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';

    protected $fillable = [
        'profile_picture',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'age',
        'nationality',
        'address',
        'zip_code',
        'guardian_first_name',
        'guardian_last_name',
        'relationship',
        'guardian_contact',
        'previous_school',
        'grade_completed',
        'school_year_completed',
        'transcript',
        'track_id',
        'studentid',
        'strand_id',
        'status',
        'class_schedule',
        'home_address',
        'contact_number',
        'email',
        'school',
        'grade_level',
        'year_graduated',
        'parent_name',
        'parent_contact',
        'parent_email',
        'payment_date',
        'downpayment',
        'payment_method',
        'paymentstatus',
        'balance',
        'receiptnumber'

    ];
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id');
    }

    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }
     public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
