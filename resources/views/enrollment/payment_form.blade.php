@extends('layouts.app')

@section('title', 'Payment Form')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
@endsection

@section('content')
<div>
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Student Payment Form</p>
    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Student Information -->
        <h5 class="section-title">Student Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="student_id" class="form-label">Student ID</label>
                    <select class="form-select" id="student_id" name="student_id" required>
                        <option value="">Select Student</option>
                        @foreach (\App\Models\Student::all() as $student)
                        <option value="{{ $student->id }}" data-first-name="{{ $student->first_name }}"
                            data-last-name="{{ $student->last_name }}" data-grade-level="{{ $student->grade_level }}"
                            data-balance="{{ $student->balance }}"
                            {{ old('student_id', $student->id ?? '') == $student->id ? 'selected' : '' }}>
                            {{ $student->studentid }} - {{ $student->first_name }} {{ $student->last_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" readonly>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" readonly>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="grade_level" class="form-label">Grade Level</label>
                    <input type="text" class="form-control" id="grade_level" name="grade_level" readonly>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="amount_due" class="form-label">Amount Due</label>
                    <input type="number" class="form-control" id="amount_due" name="amount_due" step="0.01" readonly
                        required>
                    @error('amount_due')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <h5 class="section-title">Payment Details</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date"
                        value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
                    @error('payment_date')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="receipt_number" class="form-label">Receipt Number</label>
                    <input type="text" class="form-control" id="receipt_number" name="receipt_number"
                        value="{{ old('receipt_number', 'P' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT)) }}" required>
                    @error('receipt_number')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3">
                <h6>Payment Lines</h6>
                <div id="payment-lines">
                    <div class="payment-line mb-3 row">
                        <div class="p-1 col-md-3">
                            <label for="payment_lines[0][amount]" class="form-label">Amount</label>
                            <input type="number" class="form-control" name="payment_lines[0][amount]" step="0.01"
                                required>
                            @error('payment_lines.0.amount')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 col-md-4">
                            <label for="payment_lines[0][description]" class="form-label">Description</label>
                            <input type="text" class="form-control" name="payment_lines[0][description]" required>
                            @error('payment_lines.0.description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 col-md-3">
                            <label for="payment_lines[0][payment_method]" class="form-label">Payment Method</label>
                            <select class="form-select" name="payment_lines[0][payment_method]" required>
                                <option value="">Select</option>
                                <option value="Credit Card"
                                    {{ old('payment_lines.0.payment_method') == 'Credit Card' ? 'selected' : '' }}>
                                    Credit Card</option>
                                <option value="Debit Card"
                                    {{ old('payment_lines.0.payment_method') == 'Debit Card' ? 'selected' : '' }}>Debit
                                    Card</option>
                                <option value="Cash"
                                    {{ old('payment_lines.0.payment_method') == 'Cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="Bank Transfer"
                                    {{ old('payment_lines.0.payment_method') == 'Bank Transfer' ? 'selected' : '' }}>
                                    Bank Transfer</option>
                            </select>
                            @error('payment_lines.0.payment_method')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-payment-line">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="add-payment-line">Add More
                    Payment</button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm">Submit Payment</button>
                <a href="{{ route('payments.view') }}" class="btn btn-outline-primary btn-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Populate student details when student is selected
        const studentSelect = document.getElementById('student_id');
        const firstNameInput = document.getElementById('first_name');
        const lastNameInput = document.getElementById('last_name');
        const gradeLevelInput = document.getElementById('grade_level');
        const amountDueInput = document.getElementById('amount_due');

        studentSelect.addEventListener('change', () => {
            const selectedOption = studentSelect.options[studentSelect.selectedIndex];
            firstNameInput.value = selectedOption ? selectedOption.dataset.firstName : '';
            lastNameInput.value = selectedOption ? selectedOption.dataset.lastName : '';
            gradeLevelInput.value = selectedOption ? selectedOption.dataset.gradeLevel : '';
            amountDueInput.value = selectedOption ? selectedOption.dataset.balance : '';
        });

        // Trigger change event on page load to populate fields if student_id is pre-selected
        if (studentSelect.value) {
            studentSelect.dispatchEvent(new Event('change'));
        }

        // Add payment line dynamically
        let paymentLineIndex = 1;
        document.getElementById('add-payment-line').addEventListener('click', () => {
            const paymentLinesDiv = document.getElementById('payment-lines');
            const newPaymentLine = document.createElement('div');
            newPaymentLine.classList.add('payment-line', 'mb-3', 'row');
            newPaymentLine.innerHTML = `
                <div class="p-1 col-md-3">
                    <label for="payment_lines[${paymentLineIndex}][amount]" class="form-label">Amount</label>
                    <input type="number" class="form-control" name="payment_lines[${paymentLineIndex}][amount]" step="0.01" required>
                </div>
                <div class="p-1 col-md-4">
                    <label for="payment_lines[${paymentLineIndex}][description]" class="form-label">Description</label>
                    <input type="text" class="form-control" name="payment_lines[${paymentLineIndex}][description]" required>
                </div>
                <div class="p-1 col-md-3">
                    <label for="payment_lines[${paymentLineIndex}][payment_method]" class="form-label">Payment Method</label>
                    <select class="form-select" name="payment_lines[${paymentLineIndex}][payment_method]" required>
                        <option value="">Select</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
                <div class="p-1 col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-payment-line">Remove</button>
                </div>
            `;
            paymentLinesDiv.appendChild(newPaymentLine);
            paymentLineIndex++;
        });

        // Remove payment line
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-payment-line')) {
                if (document.querySelectorAll('.payment-line').length > 1) {
                    e.target.closest('.payment-line').remove();
                } else {
                    alert('At least one payment line is required.');
                }
            }
        });
    });
</script>
@endsection