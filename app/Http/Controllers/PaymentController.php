<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create($student_id)
    {
        $student = Student::findOrFail($student_id);
        $receiptnumber = 'REC-' . Str::random(8); // Generate unique receipt number
        
        return view('payments.create', compact('student_id', 'receiptnumber'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,student_id',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:credit_card,debit_card,bank_transfer',
            'downpayment' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'receipt_number' => 'required|unique:payments,receipt_number'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Payment::create([
            'student_id' => $request->studentid,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'downpayment' => $request->downpayment,
            'balance' => $request->balance,
            'receipt_number' => $request->receipt_number,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function index()
    {
        $payments = Payment::with('student')->latest()->paginate(10);
        return view('payments.index', compact('payment'));
    }
}

