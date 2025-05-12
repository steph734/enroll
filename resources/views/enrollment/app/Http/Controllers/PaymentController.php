<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'receiptnumber' => 'required|string|unique:payments,reference_number',
            'payment_method' => 'required|string',
            'studentid' => 'required|string|exists:students,studentid',
            'description' => 'required|string'
        ]);

        $student = Student::where('studentid', $validated['studentid'])->first();
        
        // Create payment record
        $payment = new Payment();
        $payment->student_id = $student->id;
        $payment->amount = $validated['payment_amount'];
        $payment->payment_method = $validated['payment_method'];
        $payment->reference_number = $validated['receiptnumber'];
        $payment->payment_date = $validated['payment_date'];
        $payment->remarks = $validated['description'];
        $payment->processed_by = Auth::user()->name;
        $payment->save();

        // Update student's payment information
        $student->update([
            'downpayment' => $student->downpayment + $validated['payment_amount'],
            'balance' => max(0, $student->balance - $validated['payment_amount']),
            'paymentstatus' => ($student->balance - $validated['payment_amount']) <= 0 ? 'paid' : 'unpaid',
            'payment_method' => $validated['payment_method'],
            'payment_date' => $validated['payment_date']
        ]);

        return redirect()->route('payments.view', $student->studentid)
            ->with('success', 'Payment recorded successfully.');
    }

    public function view($studentId)
    {
        $student = Student::where('studentid', $studentId)->firstOrFail();
        $payments = Payment::where('student_id', $student->id)
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('view-payment', compact('student', 'payments'));
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
                    'id' => $student->id,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'balance' => $student->balance
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
            ->get(['id', 'studentid', 'first_name', 'last_name', 'balance']);

        return response()->json([
            'students' => $students
        ]);
    }
} 