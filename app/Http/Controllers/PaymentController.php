<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $filter = $request->query('filter', 'all');
        $sort = $request->query('sort', 'name-asc');
        $gradeFilter = $request->query('grade');

        $query = Payment::with(['student', 'section']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('studentid', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                    ->orWhere('grade_level', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        if ($gradeFilter) {
            $query->where('grade_level', $gradeFilter);
        }

        switch ($sort) {
            case 'name-asc':
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) ASC");
                break;
            case 'name-desc':
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) DESC");
                break;
            case 'amount-due-asc':
                $query->orderBy('balance', 'asc'); // Changed to balance
                break;
            case 'amount-due-desc':
                $query->orderBy('balance', 'desc'); // Changed to balance
                break;
        }

        $student = $query->get();

        $totalPayments = Student::sum('downpayment');
        $totalOutstanding = '₱' . number_format($student->sum('balance'), 2);
        $unpaidCount = $student->where('status', 'unpaid')->count();

        return view('payments.index', compact(
            'payments',
            'totalPayments',
            'totalOutstanding',
            'unpaidCount'
        ));
    }

    public function create()
    {
        $sections = Section::all();
        $students = Student::all();
        return view('enrollment.payment', 'payment_form', compact('section', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'studentid' => 'required|exists:students,studentid',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:255',
            'section_id' => 'nullable|exists:sections,id',
            'amount_due' => 'required|numeric|min:0',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        // Calculate balance and status
        $validated['balance'] = $validated['amount_due'] - ($validated['payment_amount'] ?? 0);
        $validated['status'] = $validated['balance'] <= 0 ? 'paid' : 'unpaid';

        $payment = Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment record created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['student', 'section']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $sections = Section::all();
        $students = Student::all();
        return view('payments.edit', compact('payment', 'sections', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'studentid' => 'required|exists:students,studentid',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:255',
            'section_id' => 'nullable|exists:sections,id',
            'amount_due' => 'required|numeric|min:0',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        // Calculate balance and status
        $validated['balance'] = $validated['amount_due'] - ($validated['payment_amount'] ?? 0);
        $validated['status'] = $validated['balance'] <= 0 ? 'paid' : 'unpaid';

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Payment record updated successfully.');
    }
}
