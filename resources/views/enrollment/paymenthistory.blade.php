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
                                    <th scope="col">Payment Date</th>
                                    <th scope="col">Receipt Number</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Balance After</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $runningBalance = $student->balance + $student->payments->sum('payment_amount');
                                @endphp
                                @forelse($student->payments->sortBy('payment_date') as $payment)
                                    @foreach($payment->paymentLines as $line)
                                    @php
                                        $runningBalance -= $line->amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('m/d/Y') : 'N/A' }}</td>
                                        <td>P{{ str_pad($line->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $line->description }}</td>
                                        <td>₱{{ number_format($line->amount, 2) }}</td>
                                        <td>{{ $line->payment_method }}</td>
                                        <td>₱{{ number_format($runningBalance, 2) }}</td>
                                    </tr>
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No payments recorded.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="mb-3 row">
        <div class="col-md-12">
            <div class="p-3 m-1 card">
                <div class="card-body">
                    <h4>Payment Summary</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Total Amount Paid:</strong> ₱{{ number_format($student->payments->sum('payment_amount'), 2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Current Balance:</strong> ₱{{ number_format($student->balance, 2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Payment Status:</strong> 
                                @if($student->balance == 0)
                                    <span class="badge bg-success">Fully Paid</span>
                                @elseif($student->payments->sum('payment_amount') > 0)
                                    <span class="badge bg-warning">Partially Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('payment.index') }}" class="btn btn-outline-primary">Back to Payments</a>
    </div>
</div>
@endsection