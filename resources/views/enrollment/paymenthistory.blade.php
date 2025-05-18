@extends('layouts.app')

@section('title', 'Payment History')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
@endsection

@section('content')
<div class="payments-content">
    <h2>Payment History for {{ $student->first_name }} {{ $student->last_name }}</h2>
    <p style="font-size: 18px; color:#555 !important;">Student ID: {{ $student->studentid }} | Grade:
        {{ $student->grade_level }}
    </p>

    <!-- Summary -->
    <div class="mb-3 row">
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-bill-wave fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($student->payments->sum('payment_amount'), 2) }}</h5>
                    <p class="card-text">Total Payments</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-balance-scale fa-2x text-warning"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($student->balance, 2) }}</h5>
                    <p class="card-text">Outstanding Balance</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-check fa-2x text-primary"></i>
                    <h5 class="mt-2 card-title">
                        ₱{{ number_format($student->payments->pluck('paymentLines')->flatten()->where('description', 'Down Payment')->sum('amount'), 2) }}
                    </h5>
                    <p class="card-text">Total Downpayments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Records -->
    <div class="mb-3 row">
        <div class="col-md-12">
            <div class="p-3 m-1 card card-table">
                <div class="card-body">
                    <h4>Payment Records</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Payment ID</th>
                                    <th scope="col">Amount Paid</th>
                                    <th scope="col">Amount Due</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Payment Date</th>
                                    <th scope="col">Receipt Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>₱{{ number_format($payment->payment_amount, 2) }}</td>
                                    <td>₱{{ number_format($payment->amount_due, 2) }}</td>
                                    <td>₱{{ number_format($payment->balance, 2) }}</td>
                                    <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('m/d/Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $payment->receipt_number ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No payments recorded.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Lines -->
    <div class="mb-3 row">
        <div class="col-md-12">
            <div class="p-3 m-1 card card-table">
                <div class="card-body">
                    <h4>Transaction Details</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Payment ID</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->payments->pluck('paymentLines')->flatten() as $line)
                                <tr>
                                    <td>{{ $line->payment_id }}</td>
                                    <td>₱{{ number_format($line->amount, 2) }}</td>
                                    <td>{{ $line->description }}</td>
                                    <td>{{ $line->payment_method }}</td>
                                    <td>{{ $line->payment->payment_date ? \Carbon\Carbon::parse($line->payment->payment_date)->format('m/d/Y') : 'N/A' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No transactions recorded.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('payments.index') }}" class="btn btn-outline-primary">Back to Payments</a>
    </div>
</div>
@endsection