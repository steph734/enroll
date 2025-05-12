<?php

namespace App\Http\Controllers;

use App\Models\Payment;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
   public function index()
    {
        // Retrieve all payments (consider adding pagination or filters)
        $transactions = Payment::all();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Store a new transaction in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'payment_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'receiptnumber' => 'required|string|unique:payments,receiptnumber',
            'payment_method' => 'required|string|in:Credit Card,Debit Card,Cash,Bank Transfer',
            'studentid' => 'required|string|exists:students,studentid',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create new payment transaction
            Payment::create([
                'studentid' => $request->studentid,
                'payment_amount' => $request->payment_amount,
                'payment_date' => $request->payment_date,
                'receiptnumber' => $request->receiptnumber,
                'payment_method' => $request->payment_method,
                'description' => $request->description,
            ]);

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction recorded successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error recording transaction: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Check if student ID exists via AJAX
     */
    public function checkStudent(Request $request)
    {
        $request->validate([
            'studentid' => 'required|string',
        ]);

        $student = Student::where('studentid', $request->studentid)->first();

        if ($student) {
            return response()->json([
                'success' => true,
                'student' => [
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Student ID not found'
        ], 404);
    }
}
