@extends('layouts.app')

@section('title', 'payment-form')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
    <style>
        .invalid-feedback { display: none; }
        .is-invalid ~ .invalid-feedback { display: block; }
        .student-info { color: green; font-weight: bold; }
        .error-message { color: red; font-weight: bold; }
    </style>
@endsection

@section('content')
<div>
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Student Payment Form</p>
    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" id="receiptnumber" name="receiptnumber" value="{{ old('receiptnumber') }}" readonly required>
                    @error('receiptnumber')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
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
                    <input type="text" class="form-control" id="studentid" name="studentid" value="{{ old('studentid') }}" required>
                    <div id="studentid-feedback" class="invalid-feedback"></div>
                    <div id="student-info" class="student-info"></div>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="description" class="form-label">Payment Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25" id="submitButton" disabled>Submit Payment</button>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-primary btn-sm w-25">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Function to generate a 6-digit receipt number
    function generateReceiptNumber() {
        return Math.floor(100000 + Math.random() * 900000); // Generates number between 100000 and 999999
    }

    // Set the receipt number and handle student ID search
    document.addEventListener('DOMContentLoaded', () => {
        const receiptField = document.getElementById('receiptnumber');
        if (!receiptField.value) {
            receiptField.value = generateReceiptNumber();
        }

        const studentIdInput = document.getElementById('studentid');
        const feedbackDiv = document.getElementById('studentid-feedback');
        const studentInfoDiv = document.getElementById('student-info');
        const submitButton = document.getElementById('submitButton');

        studentIdInput.addEventListener('input', function () {
            const studentId = this.value.trim();

            if (studentId.length === 0) {
                feedbackDiv.textContent = '';
                studentInfoDiv.textContent = '';
                studentIdInput.classList.remove('is-invalid', 'is-valid');
                submitButton.disabled = true;
                return;
            }

            // Make AJAX request to check student ID
            fetch('{{ route('payments.check-student') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ studentid: studentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    studentIdInput.classList.remove('is-invalid');
                    studentIdInput.classList.add('is-valid');
                    feedbackDiv.textContent = '';
                    studentInfoDiv.textContent = `Student: ${data.student.first_name} ${data.student.last_name}`;
                    submitButton.disabled = false;
                } else {
                    studentIdInput.classList.remove('is-valid');
                    studentIdInput.classList.add('is-invalid');
                    feedbackDiv.textContent = data.message || 'Student ID not found';
                    studentInfoDiv.textContent = '';
                    submitButton.disabled = true;
                }
            })
            .catch(error => {
                studentIdInput.classList.remove('is-valid');
                studentIdInput.classList.add('is-invalid');
                feedbackDiv.textContent = 'Error checking Student ID';
                studentInfoDiv.textContent = '';
                submitButton.disabled = true;
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection