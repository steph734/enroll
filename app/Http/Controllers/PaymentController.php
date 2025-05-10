<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        
        return redirect()->route('enrollment.show', 'payment');
    }

    public function create()
    {
        return view('enrollment.payment_form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'receiptnumber' => 'required|string',
            'payment_method' => 'required|string',
            'studentid' => 'required|string|exists:students,studentid',
            'description' => 'required|string'
        ]);

        // Assuming Student model handles payment updates
        $student = Student::where('studentid', $validated['studentid'])->first();
        $student->update([
            'downpayment' => $student->downpayment + $validated['payment_amount'],
            'balance' => $student->balance - $validated['payment_amount'],
            'paymentstatus' => $student->balance <= 0 ? 'paid' : 'unpaid',
            'payment_method' => $validated['payment_method'],
            'payment_date' => $validated['payment_date']
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Student $student)
    {
        return view('payments.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('payments.edit', compact('student'));
    }

    public function checkStudent(Request $request)
    {
        $request->validate([
            'studentid' => 'required|string'
        ]);

        $student = Student::where('studentid', $request->studentid)->first();

        if ($student) {
            return response()->json([
                'success' => true,
                'student' => [
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'studentid' => $student->studentid
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Student ID not found'
        ], 404);
    }

    public function searchStudents(Request $request)
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        $query = $request->input('query');
        $students = Student::where('studentid', 'like', "%$query%")
            ->orWhere('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->take(10)
            ->get(['studentid', 'first_name', 'last_name']);

        return response()->json([
            'students' => $students
        ]);
    }
}