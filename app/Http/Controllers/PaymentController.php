<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch all students with their payment details (adjust query as needed)
        $students = Student::with('latestPayment')->get();
        return view('students.index', compact('students'));
    }
}
