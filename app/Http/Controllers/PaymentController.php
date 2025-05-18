<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::select(
            'students.id',
            'students.studentid',
            'students.first_name',
            'students.last_name',
            'students.grade_level',
            'students.balance',
            'students.created_at'
        )
            ->leftJoin('payment', 'students.id', '=', 'payment.student_id')
            ->groupBy(
                'students.id',
                'students.studentid',
                'students.first_name',
                'students.last_name',
                'students.grade_level',
                'students.balance',
                'students.created_at'
            )
            ->with(['payments' => function ($query) {
                $query->select('student_id', DB::raw('SUM(payment_amount) as total_paid'))
                    ->groupBy('student_id');
            }]);

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('students.studentid', 'like', "%{$search}%")
                  ->orWhere('students.first_name', 'like', "%{$search}%")
                  ->orWhere('students.last_name', 'like', "%{$search}%");
            });
        }

        // Apply grade level filter
        if ($request->has('grade_level') && $request->grade_level) {
            $query->where('students.grade_level', $request->grade_level);
        }

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name-asc':
                    $query->orderBy('students.first_name', 'asc');
                    break;
                case 'name-desc':
                    $query->orderBy('students.first_name', 'desc');
                    break;
                case 'amount-paid-asc':
                case 'amount-paid-desc':
                case 'balance-asc':
                case 'balance-desc':
                    // These will be handled after pagination
                    break;
                default:
                    $query->orderBy('students.created_at', 'desc');
            }
        } else {
            $query->orderBy('students.created_at', 'desc');
        }

        // Get paginated results
        $students = $query->paginate(10)->withQueryString();

        // Transform and add payment status
        $students->getCollection()->transform(function ($student) {
            $student->total_paid = $student->payments->sum('total_paid') ?? 0;
            $student->status = $student->balance == 0 ? 'Fully Paid' : ($student->total_paid > 0 ? 'Partially Paid' : 'Unpaid');
            return $student;
        });

        // Apply payment amount and balance sorting after collection is transformed
        if ($request->has('sort')) {
            $collection = $students->getCollection();
            switch ($request->sort) {
                case 'amount-paid-asc':
                    $collection = $collection->sortBy('total_paid');
                    break;
                case 'amount-paid-desc':
                    $collection = $collection->sortByDesc('total_paid');
                    break;
                case 'balance-asc':
                    $collection = $collection->sortBy('balance');
                    break;
                case 'balance-desc':
                    $collection = $collection->sortByDesc('balance');
                    break;
            }
            $students->setCollection($collection);
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== 'all') {
            $collection = $students->getCollection()->filter(function($student) use ($request) {
                return strtolower($student->status) === $request->status;
            });
            $students->setCollection($collection);
        }

        // Calculate totals for summary cards (using original query to get accurate totals)
        $totalPayments = $query->get()->sum(function($student) {
            return $student->payments->sum('total_paid') ?? 0;
        });
        $totalBalance = $query->get()->sum('balance');
        $totalPaidStudents = $query->get()->filter(function($student) {
            return $student->balance == 0;
        })->count();

        $activePage = 'payment';

        return view('enrollment.payment', compact(
            'students',
            'activePage',
            'totalPayments',
            'totalBalance',
            'totalPaidStudents'
        ));
    }

    public function history($student_id)
    {
        $student = Student::with(['payments.paymentLines'])->findOrFail($student_id);
        $activePage = 'payment';
        return view('enrollment.paymenthistory', compact('student', 'activePage'));
    }

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
          

            return redirect()->route('payment.index')->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }
}
