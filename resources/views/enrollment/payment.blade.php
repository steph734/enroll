juonpeii_san
juonpeii_san_98288
Invisible

juonpeii_san — 14/04/2025 10:15 am
git fetch origin
git reset --hard origin/main
para dili kapuy imong kinabuhi
han — Yesterday at 11:40 pm
$table->id();
$table->string('subjectname');
$table->string('description');
$table->string('gradelevel');
$table->string('semester');
$table->string('room');
$table->date('start_date'); // Start date of the class schedule
$table->date('end_date');
$table->enum('status', ['Active', 'Inactive'])->default('Active');
$table->time('start_time')->nullable(); // Add start_time
$table->time('end_time')->nullable();
$table->foreignId('track_id')->constrained('tracks')->onDelete('cascade');
$table->foreignId('section_id')->constrained('section')->onDelete('cascade');
$table->foreignId('student_id')->constrained('students')->onDelete('cascade');
$table->timestamps();
han — 12:05 am
<?php
// File: resources/views/payments/index.blade.php
?>
@extends('layouts.app')

@section('title', 'Payments')
Expand
message.txt
15 KB
﻿
<?php
// File: resources/views/payments/index.blade.php
?>
@extends('layouts.app')

@section('title', 'Payments')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
@endsection

@section('content')
<div class="payments-content">
    <!-- Summary Cards -->
    <div class="mb-3 row">
        @php
        $totalDownpayments = \App\Models\Student::sum('downpayment');
        @endphp
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-bill-wave fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalDownpayments, 2) }}</h5>
                    <p class="card-text">Total Payments Collected</p>
                </div>
            </div>
        </div>
        @php
        $totalBalance = \App\Models\Student::sum('balance');
        @endphp
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-balance-scale fa-2x text-warning"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalBalance, 2) }}</h5>
                    <p class="card-text">Total Outstanding Balance</p>
                </div>
            </div>
        </div>
        @php
        $paidStudentsCount = \App\Models\Student::where('paymentstatus', 'paid')->count();
        @endphp
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-user-check fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">{{ $paidStudentsCount }}</h5>
                    <p class="card-text">Paid Student Count</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section with Search and Filters -->
    <div class="mb-3 row">
        <div class="row row-header-payment">
            <div class="p-3 card card-header-payment sticky-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <h5>List of Payments</h5>
                        </div>
                        <form action="" id="searchForm">
                            <div class="search-container-dash">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" placeholder="Search..." id="searchInput" class="form-control">
                                <div id="suggestions"
                                    style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Filters Section -->
                    <div class="mt-3 filters d-flex justify-content-between align-items-center">
                        <div class="gap-3 tabs d-flex">
                            <button class="tab active" data-filter="all">All Students</button>
                            <button class="tab" data-filter="paid">Paid</button>
                            <button class="tab" data-filter="unpaid">Unpaid</button>
                        </div>

                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select filter-select" id="gradeLevelFilter" style="width: 150px;">
                                <option value="">All Grade Levels</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                            <select class="form-select filter-select" id="paymentStatusFilter" style="width: 150px;">
                                <option value="">All Payment Statuses</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                            <select class="form-select filter-select" id="paymentMethodFilter" style="width: 150px;">
                                <option value="">All Payment Methods</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                            <button class="btn btn-outline-dark btn-sm p-1" id="clearFilters">
                                <i class="fa-solid fa-eraser"></i> Clear Filters
                            </button>
                        </div>

                        <a href="{{ route('payments.create', 'payment_form') }}">
                            <button class="btn btn-primary add-payment">Add Payment</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="mb-3 row">
        <div class="p-3 card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th scope="col" class="p-1 text-center align-middle">Student ID</th>
                                <th scope="col" class="p-1 text-center align-middle">Full Name</th>
                                <th scope="col" class="p-1 text-center align-middle">Grade & Section</th>
                                <th scope="col" class="p-1 text-center align-middle">Payment Method</th>
                                <th scope="col" class="p-1 text-center align-middle">Amount Paid</th>
                                <th scope="col" class="p-1 text-center align-middle">Balance</th>
                                <th scope="col" class="p-1 text-center align-middle">Status</th>
                                <th scope="col" class="p-1 text-center align-middle">Payment Date</th>
                                <th scope="col" class="p-1 text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTable">
                            @forelse(\App\Models\Student::all() as $student)
                            <tr class="payment-row" data-grade-level="{{ $student->grade_level }}"
                                data-payment-status="{{ $student->paymentstatus }}"
                                data-payment-method="{{ $student->payment_method }}">
                                <td class="text-center">{{ $student->studentid }}</td>
                                <td class="text-center">{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td class="text-center">{{ $student->grade_level }} -
                                    {{ $student->section ? $student->section->code : 'N/A' }}
                                </td>
                                <td class="text-center">{{ $student->payment_method ?: 'N/A' }}</td>
                                <td class="text-center">₱{{ number_format($student->downpayment, 2) }}</td>
                                <td class="text-center">₱{{ number_format($student->balance, 2) }}</td>
                                <td class="text-center">{{ $student->paymentstatus }}</td>
                                <td class="text-center">
                                    {{ $student->payment_date ? \Carbon\Carbon::parse($student->payment_date)->format('m/d/Y') : 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <div class="gap-2 d-flex justify-content-center">
                                        <a href="{{ route('payments.show', $student) }}" class="btn" title="View">
                                            <i class="fa-solid fa-eye" style="color:#305cde;"></i>
                                        </a>
                                        <a href="{{ route('payments.edit', $student) }}" class="btn" title="Edit">
                                            <i class="fa-solid fa-pen-to-square" style="color:#ffc107;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="p-3 text-center">No payments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('suggestions');
        const paymentRows = document.querySelectorAll('.payment-row');
        const gradeLevelFilter = document.getElementById('gradeLevelFilter');
        const paymentStatusFilter = document.getElementById('paymentStatusFilter');
        const paymentMethodFilter = document.getElementById('paymentMethodFilter');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const tabs = document.querySelectorAll('.tab');

        // Debounce function for search
        const debounce = (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        // Apply all filters
        const applyFilters = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatusTab = document.querySelector('.tab.active').getAttribute('data-filter');
            const selectedGradeLevel = gradeLevelFilter.value;
            const selectedPaymentStatus = paymentStatusFilter.value;
            const selectedPaymentMethod = paymentMethodFilter.value;

            paymentRows.forEach(row => {
                const studentId = row.cells[0].textContent.toLowerCase();
                const fullName = row.cells[1].textContent.toLowerCase();
                const gradeSection = row.cells[2].textContent.toLowerCase();
                const gradeLevel = row.getAttribute('data-grade-level');
                const paymentStatus = row.getAttribute('data-payment-status').toLowerCase();
                const paymentMethod = row.getAttribute('data-payment-method')?.toLowerCase() || '';

                const matchesSearch = !searchTerm ||
                    studentId.includes(searchTerm) ||
                    fullName.includes(searchTerm) ||
                    gradeSection.includes(searchTerm);

                const matchesTab = selectedStatusTab === 'all' ||
                    paymentStatus === selectedStatusTab;

                const matchesGradeLevel = !selectedGradeLevel || gradeLevel === selectedGradeLevel;
                const matchesPaymentStatus = !selectedPaymentStatus || paymentStatus ===
                    selectedPaymentStatus;
                const matchesPaymentMethod = !selectedPaymentMethod || paymentMethod ===
                    selectedPaymentMethod.toLowerCase();

                row.style.display = matchesSearch && matchesTab && matchesGradeLevel &&
                    matchesPaymentStatus && matchesPaymentMethod ? '' : 'none';
            });
        };

        // Search suggestions
        const updateSuggestions = debounce(() => {
            const searchTerm = searchInput.value.toLowerCase();
            suggestionsDiv.innerHTML = '';
            if (searchTerm.length < 2) {
                suggestionsDiv.style.display = 'none';
                return;
            }

            const matches = Array.from(paymentRows).filter(row => {
                const studentId = row.cells[0].textContent.toLowerCase();
                const fullName = row.cells[1].textContent.toLowerCase();
                return studentId.includes(searchTerm) || fullName.includes(searchTerm);
            });

            if (matches.length) {
                matches.slice(0, 5).forEach(row => {
                    const suggestion = document.createElement('div');
                    suggestion.classList.add('p-2');
                    suggestion.textContent = row.cells[1].textContent;
                    suggestion.addEventListener('click', () => {
                        searchInput.value = suggestion.textContent;
                        suggestionsDiv.style.display = 'none';
                        applyFilters();
                    });
                    suggestionsDiv.appendChild(suggestion);
                });
                suggestionsDiv.style.display = 'block';
            } else {
                suggestionsDiv.style.display = 'none';
            }
        }, 300);

        // Event listeners
        searchInput.addEventListener('input', () => {
            updateSuggestions();
            applyFilters();
        });

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        gradeLevelFilter.addEventListener('change', applyFilters);
        paymentStatusFilter.addEventListener('change', applyFilters);
        paymentMethodFilter.addEventListener('change', applyFilters);

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            gradeLevelFilter.value = '';
            paymentStatusFilter.value = '';
            paymentMethodFilter.value = '';
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelector('.tab[data-filter="all"]').classList.add('active');
            suggestionsDiv.style.display = 'none';
            applyFilters();
        });
    });
</script>
@endsection
message.txt
15 KB