@extends('layouts.app')

@section('title', 'payment-form')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
@endsection

@section('content')
<div>
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Student Payment Form</p>
    <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Payment -->
        <h5 class="section-title">Payment</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_amount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="payment_amount" name="payment_amount" step="0.01" required min="0">
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="receipt_number" class="form-label">Receipt Number</label>
                    <input type="text" class="form-control" id="receipt_number" name="receipt_number" value="P03" required>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="">Select</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="studentid" class="form-label">Student ID</label>
                    <input type="text" class="form-control" id="studentid" name="studentid" value="{{ $studentid ?? '' }}" readonly required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="amount_due" class="form-label">Amount Due</label>
                    <input type="text" class="form-control" id="amount_due" name="amount_due" value="40000" readonly required>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Submit Payment</button>
                <a href="{{ route('students.index') }}" class="btn btn-primary btn-lg w-25">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Function to generate a 6-digit student ID
    function generateStudentID() {
        return Math.floor(100000 + Math.random() * 900000); // Generates number between 100000 and 999999
    }

    // Set the student ID value when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        const studentIDField = document.getElementById('studentid');
        if (!studentIDField.value) { // Only set if the field is empty
            studentIDField.value = generateStudentID();
        }
    });
</script>
@endsection