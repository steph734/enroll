@extends('layouts.app')

@section('title', 'Payment History')

@section('styles')
<style>
    .payment-header {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .student-info {
        margin-bottom: 10px;
    }
    .payment-card {
        border-left: 4px solid #007bff;
        margin-bottom: 15px;
    }
    .payment-amount {
        font-size: 1.2em;
        font-weight: bold;
        color: #28a745;
    }
    .payment-date {
        color: #6c757d;
    }
    .balance-info {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Payments
        </a>
    </div>

    <div class="payment-header">
        <div class="row">
            <div class="col-md-8">
                <h2>Payment History</h2>
                <div class="student-info">
                    <p><strong>Student ID:</strong> {{ $student->studentid }}</p>
                    <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                    <p><strong>Grade & Section:</strong> {{ $student->grade_level }} - {{ $student->section ? $student->section->code : 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="balance-info">
                    <h4>Payment Summary</h4>
                    <p><strong>Total Amount Paid:</strong> ₱{{ number_format($student->downpayment, 2) }}</p>
                    <p><strong>Remaining Balance:</strong> ₱{{ number_format($student->balance, 2) }}</p>
                    <p><strong>Status:</strong> 
                        @if($student->balance == 0)
                            <span class="badge bg-success">Fully Paid</span>
                        @else
                            <span class="badge bg-warning">Partially Paid</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="payment-history">
        <h3>Payment Transactions</h3>
        @if($payments->count() > 0)
            @foreach($payments as $payment)
            <div class="card payment-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="payment-amount">
                                ₱{{ number_format($payment->amount, 2) }}
                            </div>
                            <div class="payment-date">
                                <i class="fa-regular fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                            <p><strong>Reference Number:</strong> {{ $payment->reference_number ?? 'N/A' }}</p>
                            <p><strong>Remarks:</strong> {{ $payment->remarks ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Processed by:</strong> {{ $payment->processed_by }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-success">Confirmed</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="alert alert-info">
                No payment transactions found for this student.
            </div>
        @endif
    </div>
</div>
@endsection 