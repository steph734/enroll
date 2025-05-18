<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        // Aggregate total payments per student
        $students = Student::select(
            'students.id',
            'students.studentid',
            'students.first_name',
            'students.last_name',
            'students.grade_level',
            'students.balance',
            'students.section_id'
        )
            ->leftJoin('payment', 'students.id', '=', 'payment.student_id')
            ->groupBy(
                'students.id',
                'students.studentid',
                'students.first_name',
                'students.last_name',
                'students.grade_level',
                'students.balance',
                'students.section_id'
            )
            ->with(['payments' => function ($query) {
                $query->select('student_id', DB::raw('SUM(payment_amount) as total_paid'))
                    ->groupBy('student_id');
            }])
            ->get()
            ->map(function ($student) {
                $student->total_paid = $student->payments->sum('total_paid') ?? 0;
                $student->status = $student->balance == 0 ? 'Fully Paid' : ($student->total_paid > 0 ? 'Partially Paid' : 'Unpaid');
                return $student;
            });
        $activePage = 'payment';

        return view('enrollment.payment', compact('students', 'activePage'));
    }

    public function history($student_id)
    {
        $student = Student::with(['payments.paymentLines'])->findOrFail($student_id);
        return view('enrollment.paymenthistory', compact('student'));
    }

    public function create($student_id = null)
    {
        $students = Student::all();
        return view('enrollment.payment_form', compact('student_id', 'students'));
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

            $student = Student::findOrFail($validated['student_id']);

            if ($validated['amount_due'] != $student->balance) {
                throw new \Exception('Amount due does not match student balance.');
            }

            $totalPaymentAmount = array_sum(array_column($validated['payment_lines'], 'amount'));

            if ($totalPaymentAmount > $student->balance) {
                throw new \Exception('Payment amount exceeds student balance.');
            }

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
                'receipt_number' => $validated['receipt_number'],
            ]);

            foreach ($validated['payment_lines'] as $line) {
                \App\Models\PaymentLine::create([
                    'student_id' => $validated['student_id'],
                    'payment_id' => $payment->id,
                    'amount' => $line['amount'],
                    'description' => $line['description'],
                    'payment_method' => $line['payment_method'],
                ]);
            }

            $student->balance -= $totalPaymentAmount;
            $student->save();

            DB::commit();

            return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }
}
