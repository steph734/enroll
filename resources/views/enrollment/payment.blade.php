@extends('layouts.app')

@section('title', 'Payments')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
@endsection

@section('content')
<div class="payments-content">
    <h2>List of Payments</h2>
    <p style="font-size: 18px; color:#555 !important;">For 1st Semester, Class of 2024-2025</p>

    <!-- Success Message -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Summary Cards -->
    @php
    $totalPayments = \App\Models\Payment::sum('payment_amount');
    $totalBalance = \App\Models\Student::sum('balance');
    $totalPaidStudents = \App\Models\Student::where('balance', 0)->count();
    $totalDownpayments = \App\Models\PaymentLine::where('description', 'Down Payment')->sum('amount');
    @endphp
    <div class="mb-3 row">
        <div class="col-md-3">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-bill-wave fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalPayments, 2) }}</h5>
                    <p class="card-text">Total Payments Collected</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-balance-scale fa-2x text-warning"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalBalance, 2) }}</h5>
                    <p class="card-text">Total Outstanding Balance</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-user-check fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">{{ $totalPaidStudents }}</h5>
                    <p class="card-text">Fully Paid Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-check fa-2x text-primary"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalDownpayments, 2) }}</h5>
                    <p class="card-text">Total Downpayments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section with Search and Filters -->
    <div class="mb-3 row">
        <div class="col-md-12">
            <div class="p-3 m-1 card card-header-payment sticky-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title"></div>
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
                            <button class="tab active" data-filter="all">All Payments</button>
                            <button class="tab" data-filter="paid">Paid</button>
                            <button class="tab" data-filter="unpaid">Unpaid</button>
                            <button class="tab" data-filter="downpayment">Downpayment</button>
                        </div>
                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select form-select-sm" id="gradeLevelFilter" style="width: 150px;">
                                <option value="">All Grade Levels</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                            <select class="form-select form-select-sm" id="paymentMethodFilter" style="width: 150px;">
                                <option value="">All Payment Methods</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Debit Card">Debit Card</option>
                            </select>
                            <select class="form-select form-select-sm" id="sortBy" style="width: 150px;">
                                <option value="">Sort By</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="amount-paid-asc">Amount Paid (Low to High)</option>
                                <option value="amount-paid-desc">Amount Paid (High to Low)</option>
                                <option value="balance-asc">Balance (Low to High)</option>
                                <option value="balance-desc">Balance (High to Low)</option>
                            </select>
                            <a href="#">
                                <button class="btn btn-outline-dark btn-sm" id="clearFilters">
                                    <i class="fa-solid fa-eraser"></i> Clear Filters
                                </button>
                            </a>
                            <a href="{{ route('payments.create') }}">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-plus"></i> Add Payment
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="mb-3 row">
        <div class="col-md-12">
            <div class="p-3 m-1 card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">Student ID</th>
                                    <th scope="col" class="align-middle">Full Name</th>
                                    <th scope="col" class="align-middle">Grade & Section</th>
                                    <th scope="col" class="align-middle">Payment Method</th>
                                    <th scope="col" class="align-middle">Amount Paid</th>
                                    <th scope="col" class="align-middle">Downpayment</th>
                                    <th scope="col" class="align-middle">Balance</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Payment Date</th>
                                    <th scope="col" class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody id="paymentsTable">
                                @forelse($payments as $payment)
                                <tr class="payment-row"
                                    data-status="{{ $payment->balance == 0 ? 'fullypaid' : 'paid' }}"
                                    data-grade-level="{{ $payment->grade_level }}"
                                    data-payment-method="{{ $payment->paymentLines->first()->payment_method ?? 'N/A' }}"
                                    data-amount-paid="{{ $payment->payment_amount }}"
                                    data-balance="{{ $payment->balance }}"
                                    data-downpayment="{{ $payment->paymentLines->where('description', 'Down Payment')->sum('amount') > 0 ? 'yes' : 'no' }}">
                                    <td>{{ $payment->student->studentid }}</td>
                                    <td>{{ $payment->first_name }} {{ $payment->last_name }}</td>
                                    <td>{{ $payment->grade_level }} -
                                        {{ $payment->section ? $payment->section->code : 'N/A' }}
                                    </td>
                                    <td>{{ $payment->paymentLines->first()->payment_method ?? 'N/A' }}</td>
                                    <td>₱{{ number_format($payment->payment_amount, 2) }}</td>
                                    <td>₱{{ number_format($payment->paymentLines->where('description', 'Down Payment')->sum('amount'), 2) }}
                                    </td>
                                    <td>₱{{ number_format($payment->balance, 2) }}</td>
                                    <td>{{ $payment->balance == 0 ? 'Fully Paid' : 'Paid' }}</td>
                                    <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('m/d/Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="gap-2 d-flex justify-content-center">
                                            <button class="btn view-transactions"
                                                data-student-id="{{ $payment->student_id }}" data-bs-toggle="modal"
                                                data-bs-target="#transactionModal" title="View Transactions">
                                                <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                            </button>
                                            <a href="{{ route('payments.view', $payment->student_id) }}">
                                                <button class="btn" title="View Details">
                                                    <i class="fa-solid fa-info-circle"
                                                        style="color:#007bff; font-size: 18px;"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No payments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">Payment History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="loadingSpinner" class="text-center" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <table class="table table-striped" id="transactionTable">
                        <thead>
                            <tr>
                                <th scope="col">Payment ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Description</th>
                                <th scope="col">Payment Date</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody"></tbody>
                    </table>
                    <div id="noTransactions" class="text-center" style="display: none;">
                        No payment history found for this student.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('suggestions');
        const paymentRows = document.querySelectorAll('.payment-row');
        const gradeLevelFilter = document.getElementById('gradeLevelFilter');
        const paymentMethodFilter = document.getElementById('paymentMethodFilter');
        const sortBy = document.getElementById('sortBy');
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
            const selectedStatus = document.querySelector('.tab.active').getAttribute('data-filter');
            const selectedGradeLevel = gradeLevelFilter.value;
            const selectedPaymentMethod = paymentMethodFilter.value;
            const sortValue = sortBy.value;

            let filteredRows = Array.from(paymentRows);

            // Filter rows
            filteredRows = filteredRows.filter(row => {
                const studentId = row.cells[0].textContent.toLowerCase();
                const fullName = row.cells[1].textContent.toLowerCase();
                const gradeSection = row.cells[2].textContent.toLowerCase();
                const status = row.getAttribute('data-status');
                const gradeLevel = row.getAttribute('data-grade-level');
                const paymentMethod = row.getAttribute('data-payment-method')?.toLowerCase() || '';
                const hasDownpayment = row.getAttribute('data-downpayment');

                const matchesSearch = !searchTerm ||
                    studentId.includes(searchTerm) ||
                    fullName.includes(searchTerm) ||
                    gradeSection.includes(searchTerm);

                const matchesStatus = selectedStatus === 'all' ||
                    (selectedStatus === 'fullypaid' && status === 'fullypaid') ||
                    (selectedStatus === 'paid' && status === 'paid') ||
                    (selectedStatus === 'unpaid' && status === 'unpaid') ||
                    (selectedStatus === 'downpayment' && hasDownpayment === 'yes');

                const matchesGradeLevel = !selectedGradeLevel || gradeLevel === selectedGradeLevel;
                const matchesPaymentMethod = !selectedPaymentMethod || paymentMethod ===
                    selectedPaymentMethod.toLowerCase();

                return matchesSearch && matchesStatus && matchesGradeLevel && matchesPaymentMethod;
            });

            // Sort rows
            filteredRows.sort((a, b) => {
                if (sortValue === 'name-asc') {
                    return a.cells[1].textContent.localeCompare(b.cells[1].textContent);
                } else if (sortValue === 'name-desc') {
                    return b.cells[1].textContent.localeCompare(a.cells[1].textContent);
                } else if (sortValue === 'amount-paid-asc') {
                    const aAmount = parseFloat(a.getAttribute('data-amount-paid'));
                    const bAmount = parseFloat(b.getAttribute('data-amount-paid'));
                    return aAmount - bAmount;
                } else if (sortValue === 'amount-paid-desc') {
                    const aAmount = parseFloat(a.getAttribute('data-amount-paid'));
                    const bAmount = parseFloat(b.getAttribute('data-amount-paid'));
                    return bAmount - aAmount;
                } else if (sortValue === 'balance-asc') {
                    const aBalance = parseFloat(a.getAttribute('data-balance'));
                    const bBalance = parseFloat(b.getAttribute('data-balance'));
                    return aBalance - bBalance;
                } else if (sortValue === 'balance-desc') {
                    const aBalance = parseFloat(a.getAttribute('data-balance'));
                    const bBalance = parseFloat(b.getAttribute('data-balance'));
                    return bBalance - aBalance;
                }
                return 0;
            });

            // Update table
            const tbody = document.getElementById('paymentsTable');
            tbody.innerHTML = '';
            filteredRows.forEach(row => tbody.appendChild(row));

            // Show/hide rows based on filters
            paymentRows.forEach(row => {
                row.style.display = filteredRows.includes(row) ? '' : 'none';
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
        paymentMethodFilter.addEventListener('change', applyFilters);
        sortBy.addEventListener('change', applyFilters);

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            gradeLevelFilter.value = '';
            paymentMethodFilter.value = '';
            sortBy.value = '';
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelector('.tab[data-filter="all"]').classList.add('active');
            suggestionsDiv.style.display = 'none';
            applyFilters();
        });

        // Handle transaction modal
        document.querySelectorAll('.view-transactions').forEach(button => {
            button.addEventListener('click', function() {
                const studentId = this.getAttribute('data-student-id');
                const transactionTableBody = document.getElementById('transactionTableBody');
                const noTransactions = document.getElementById('noTransactions');
                const loadingSpinner = document.getElementById('loadingSpinner');

                loadingSpinner.style.display = 'block';
                transactionTableBody.innerHTML = '';
                noTransactions.style.display = 'none';

                fetch(`/api/payments/${studentId}/transactions`)
                    .then(response => response.json())
                    .then(data => {
                        loadingSpinner.style.display = 'none';
                        if (data.length === 0) {
                            noTransactions.style.display = 'block';
                            return;
                        }
                        data.forEach(transaction => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${transaction.payment_id}</td>
                                <td>₱${parseFloat(transaction.amount).toFixed(2)}</td>
                                <td>${transaction.payment_method}</td>
                                <td>${transaction.description}</td>
                                <td>${new Date(transaction.payment_date).toLocaleDateString('en-US')}</td>
                            `;
                            transactionTableBody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        loadingSpinner.style.display = 'none';
                        noTransactions.style.display = 'block';
                        console.error('Error fetching transactions:', error);
                    });
            });
        });
    });
</script>
@endsection