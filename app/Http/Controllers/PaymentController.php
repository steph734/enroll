<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentLine;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function create($student_id = null)
    {
        $students = Student::all();
        $activePage = 'payment';
        return view('enrollment.payment_form', compact('student_id', 'students', 'activePage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_due' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'receipt_number' => 'required|string|max:255',
            'payment_lines' => 'required|array|min:1',
            'payment_lines.*.amount' => 'required|numeric|min:0',
            'payment_lines.*.description' => 'required|string|max:255',
            'payment_lines.*.payment_method' => 'required|in:Credit Card,Debit Card,Cash,Bank Transfer',
        ]);

        try {
            DB::beginTransaction();

            // Fetch student
            $student = Student::findOrFail($validated['student_id']);

            // Verify amount_due matches student's balance
            if ($validated['amount_due'] != $student->balance) {
                throw new \Exception('Amount due does not match student balance.');
            }

            // Calculate total payment amount
            $totalPaymentAmount = array_sum(array_column($validated['payment_lines'], 'amount'));

            // Verify payment doesn't exceed balance
            if ($totalPaymentAmount > $student->balance) {
                throw new \Exception('Payment amount exceeds student balance.');
            }

            // Create Payment record
            $payment = Payment::create([
                'student_id' => $validated['student_id'],
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'grade_level' => $student->grade_level,
                'section_id' => $student->section_id ?? null,
                'amount_due' => $validated['amount_due'],
                'payment_amount' => $totalPaymentAmount,
                'balance' => $student->balance - $totalPaymentAmount,
                'status' => ($student->balance - $totalPaymentAmount) <= 0 ? 'paid' : 'unpaid',
                'payment_date' => $validated['payment_date'],
            ]);

            // Add PaymentLine records and track downpayment
            $downpaymentAmount = 0;
            foreach ($validated['payment_lines'] as $line) {
                $paymentLine = PaymentLine::create([
                    'student_id' => $validated['student_id'],
                    'payment_id' => $payment->id,
                    'amount' => $line['amount'],
                    'description' => $line['description'],
                    'payment_method' => $line['payment_method'],
                ]);
                if (strtolower($line['description']) == 'down payment') {
                    $downpaymentAmount += $line['amount'];
                }
            }

            // Update student's balance and downpayment
            $student->balance -= $totalPaymentAmount;
            if ($downpaymentAmount > 0) {
                $student->downpayment = ($student->downpayment ?? 0) + $downpaymentAmount;
            }
            $student->save();

            DB::commit();

            return Redirect::route('payments.index')->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $payments = Payment::with('student')->get();
        $activePage = 'payment';
        return view('enrollment.payment', compact('payments', 'activePage'));
    }
}
