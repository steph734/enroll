@extends('layouts.app')

@section('title', 'Student Transactions')

@section('content')
<div class="container mt-4">
    <h4>Payment Transactions for {{ $student->first_name }} {{ $student->last_name }}</h4>
    <p><strong>Student ID:</strong> {{ $student->studentid }}</p>
    <p><strong>Grade & Section:</strong> {{ $student->grade_level }} - {{ $student->section->code ?? 'N/A' }}</p>

    @if($student->payments->count())
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                    <th>Amount Paid</th>
                    <th>Reference No.</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->payments()->orderByDesc('payment_date')->get() as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->reference_number ?? 'N/A' }}</td>
                    <td>{{ $payment->remarks ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info mt-3">
        No transactions found for this student.
    </div>
    @endif

    <a href="{{ route('payments.index') }}" class="btn btn-secondary mt-3">← Back to Payments</a>
</div>
@endsection
