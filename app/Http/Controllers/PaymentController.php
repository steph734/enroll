<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
  
        public function index(Request $request)
        {
            try {
                $query = Payment::with('student.section');
    
                // Handle search
                $search = $request->input('search');
                if ($search) {
                    $query->whereHas('student', function ($q) use ($search) {
                        $q->where('studentid', 'like', "%{$search}%")
                          ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                          ->orWhere('grade_level', 'like', "%{$search}%");
                    })->orWhere('status', 'like', "%{$search}%");
                }
    
                // Handle status filter
                $status = $request->input('status', 'all');
                if ($status !== 'all') {
                    $query->where('status', $status);
                }
    
                // Handle sorting
                $sort = $request->input('sort', 'name-asc');
                switch ($sort) {
                    case 'name-asc':
                        $query->join('students', 'payments.student_id', '=', 'students.id')
                              ->orderBy('students.first_name')
                              ->orderBy('students.last_name');
                        break;
                    case 'name-desc':
                        $query->join('students', 'payments.student_id', '=', 'students.id')
                              ->orderByDesc('students.first_name')
                              ->orderByDesc('students.last_name');
                        break;
                    case 'amount-due-asc':
                        $query->orderBy('amount_due');
                        break;
                    case 'amount-due-desc':
                        $query->orderByDesc('amount_due');
                        break;
                }
    
                // Fetch payments
                $payments = $query->select('payments.*')->get();
    
                // Calculate summary data
                $totalCollected = Payment::sum('amount_paid') ?? 0;
                $totalOutstanding = Payment::sum('balance') ?? 0;
                $unpaidCount = Payment::where('status', 'unpaid')->distinct('student_id')->count('student_id') ?? 0;
    
                // Log for debugging
                Log::info('PaymentController::index', [
                    'totalCollected' => $totalCollected,
                    'totalOutstanding' => $totalOutstanding,
                    'unpaidCount' => $unpaidCount,
                    'paymentCount' => $payments->count(),
                ]);
    
                return view('payments.index', compact('students', 'totalPayments', 'totalOutstanding', 'unpaidCount', 'filter', 'sort'));
            } catch (\Exception $e) {
                Log::error('Error in PaymentController::index: ' . $e->getMessage());
                return view('payment', [
                    'payments' => collect(),
                    'totalCollected' => 0,
                    'totalOutstanding' => 0,
                    'unpaidCount' => 0,
                    'error' => 'An error occurred while loading payments.'
                ]);
            }
        }

    /**
     * Show the form for creating a new payment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $students = Student::all(); // For dropdown in form
        return view('payment.create', compact('students'));
    }

    /**
     * Store a newly created payment in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_due' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        $balance = $validated['amount_due'] - $validated['amount_paid'];
        $status = $balance <= 0 ? 'paid' : 'unpaid';

        Payment::create([
            'student_id' => $validated['student_id'],
            'amount_due' => $validated['amount_due'],
            'amount_paid' => $validated['amount_paid'],
            'balance' => $balance,
            'status' => $status,
            'payment_date' => $validated['payment_date'],
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Show the form for editing a payment.
     *
     * @param Payment $payment
     * @return \Illuminate\View\View
     */
    public function edit(Payment $payment)
    {
        $students = Student::all();
        return view('payments.edit', compact('payment', 'students'));
    }

    /**
     * Update the specified payment in storage.
     *
     * @param Request $request
     * @param Payment $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_due' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        $balance = $validated['amount_due'] - $validated['amount_paid'];
        $status = $balance <= 0 ? 'paid' : 'unpaid';

        $payment->update([
            'student_id' => $validated['student_id'],
            'amount_due' => $validated['amount_due'],
            'amount_paid' => $validated['amount_paid'],
            'balance' => $balance,
            'status' => $status,
            'payment_date' => $validated['payment_date'],
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }
}

