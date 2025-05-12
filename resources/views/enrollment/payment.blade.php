@extends('layouts.app')

@section('title', 'Payments')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">
<style>
    .invalid-feedback { display: none; }
    .is-invalid ~ .invalid-feedback { display: block; }
    .student-info { color: green; font-weight: bold; }
    .error-message { color: red; font-weight: bold; }
    .nav-tabs .nav-link.active { background-color: #007bff; color: white; }
    .nav-tabs .nav-link { cursor: pointer; }
</style>
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
                    <h5 class="mt-2 card-title">₱ {{ number_format($totalDownpayments, 2) }}</h5>
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
                    <h5 class="mt-2 card-title">₱ {{ number_format($totalBalance, 2) }}</h5>
                    <p class="card-text">Total Outstanding Balance</p>
                </div>
            </div>
        </div>
        @php
        $totalstudent = \App\Models\Student::where('balance', 0)->count();
        @endphp
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-user-check fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">{{ $totalstudent }}</h5>
                    <p class="card-text">Fully Paid Student Count</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section with Search -->
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
                        <!-- Tabs for filtering by payment status -->
                        <div class="gap-3 tabs d-flex">
                            <button class="tab active" data-filter="all">ALL Students</button>
                            <button class="tab" data-filter="paid">Paid</button>
                            <button class="tab" data-filter="fullypaid">Fully Paid</button>
                        </div>

                        <!-- Dropdowns for Filter by and Sort by -->
                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="grade">Grade & Section</option>
                                <option value="status">Status</option>
                                <option value="payment-date">Payment Date</option>
                            </select>
                            <select class="form-select" style="width: 150px;">
                                <option>Sort by</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="amount-due-asc">Amount Due (Low to High)</option>
                                <option value="amount-due-desc">Amount Due (High to Low)</option>
                            </select>
                        </div>

                        <a href="{{ route('payments.create') }}" class="btn btn-primary add-payment">Add Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="mb-3 row">
        <div class="p-3 gif-container card card-table">
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
                                <th scope="col" class="align-middle">Balance</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle">Payment Date</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTable">
                            @forelse(\App\Models\Student::all() as $student)
                            <tr class="payment-row" data-status="{{ $student->balance == 0 ? 'fullypaid' : 'paid' }}">
                                <td>{{ $student->studentid }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->grade_level }} - {{ $student->section ? $student->section->code : 'N/A' }}</td>
                                <td>{{ $student->payment_method ?? 'N/A' }}</td>
                                <td>₱{{ number_format($student->downpayment, 2) }}</td>
                                <td>₱{{ number_format($student->balance, 2) }}</td>
                                <td>
                                    @if($student->balance == 0)
                                        Fully Paid
                                    @else
                                        Paid
                                    @endif
                                </td>
                                <td>{{ $student->payment_date ? \Carbon\Carbon::parse($student->payment_date)->format('m/d/Y') : 'N/A' }}</td>
                                <td>
                                    <div class="gap-2 d-flex justify-content-center">
                                        <button class="btn view-transactions" data-student-id="{{ $student->studentid }}" data-bs-toggle="modal" data-bs-target="#transactionModal" title="View Transactions">
                                            <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                        </button>
                                      <a href="{{ route('payments.view', $student->studentid) }}">
                                <button class="btn" title="View Details">
                                 <i class="fa-solid fa-info-circle" style="color:#007bff; font-size: 18px;"></i>
             </button>
</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No payments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
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
                                <th scope="col">Payment Date</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody">
                            <!-- Transaction rows will be populated here via AJAX -->
                        </tbody>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const paymentRows = document.querySelectorAll('.payment-row');

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();

        paymentRows.forEach(row => {
            const studentId = row.cells[0].textContent.toLowerCase();
            const fullName = row.cells[1].textContent.toLowerCase();
            const gradeSection = row.cells[2].textContent.toLowerCase();
            const status = row.cells[6].textContent.toLowerCase();

            if (studentId.includes(searchTerm) ||
                fullName.includes(searchTerm) ||
                gradeSection.includes(searchTerm) ||
                status.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Tab filtering
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            paymentRows.forEach(row => {
                const status = row.getAttribute('data-status').toLowerCase();
                if (filter === 'all' || status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Sort functionality
    const sortSelect = document.querySelectorAll('.form-select')[1]; // Second select is for sorting
    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        const tbody = document.getElementById('paymentsTable');
        const rows = Array.from(paymentRows);

        rows.sort((a, b) => {
            if (sortValue === 'name-asc') {
                return a.cells[1].textContent.localeCompare(b.cells[1].textContent);
            } else if (sortValue === 'name-desc') {
                return b.cells[1].textContent.localeCompare(a.cells[1].textContent);
            } else if (sortValue === 'amount-due-asc') {
                const aAmount = parseFloat(a.cells[5].textContent.replace('₱', '').replace(',', ''));
                const bAmount = parseFloat(b.cells[5].textContent.replace('₱', '').replace(',', ''));
                return aAmount - bAmount;
            } else if (sortValue === 'amount-due-desc') {
                const aAmount = parseFloat(a.cells[5].textContent.replace('₱', '').replace(',', ''));
                const bAmount = parseFloat(b.cells[5].textContent.replace('₱', '').replace(',', ''));
                return bAmount - aAmount;
            }
            return 0;
        });

        rows.forEach(row => tbody.appendChild(row));
    });

    // Function to load transactions for a specific student
    function loadTransactions(studentId, modalLabel) {
        const transactionTableBody = document.getElementById('transactionTableBody');
        const noTransactions = document.getElementById('noTransactions');
        const loadingSpinner = document.getElementById('loadingSpinner');

        loadingSpinner.style.display = 'block';
        transactionTableBody.innerHTML = '';
        noTransactions.style.display = 'none';

        fetch(`/payments/history/${studentId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status === 419 ? 'Session expired. Please refresh the page.' : 'Failed to fetch payment history.');
            }
            return response.json();
        })
        .then(data => {
            loadingSpinner.style.display = 'none';
            modalLabel.textContent = `Payment History for Student ID: ${studentId}`;

            if (data.transactions && data.transactions.length > 0) {
                data.transactions.forEach(transaction => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${transaction.receiptnumber || 'N/A'}</td>
                        <td>₱${isNaN(parseFloat(transaction.amount)) ? '0.00' : parseFloat(transaction.amount).toFixed(2)}</td>
                        <td>${transaction.payment_method || 'N/A'}</td>
                        <td>${transaction.payment_date ? new Date(transaction.payment_date).toLocaleDateString('en-US') : 'N/A'}</td>
                        <td>${transaction.remarks || 'N/A'}</td>
                    `;
                    transactionTableBody.appendChild(row);
                });
            } else {
                noTransactions.style.display = 'block';
            }
        })
        .catch(error => {
            loadingSpinner.style.display = 'none';
            noTransactions.style.display = 'block';
            noTransactions.textContent = error.message.includes('Session expired') 
                ? 'Session expired. Please refresh the page.' 
                : 'Error loading payment history. Please try again later.';
            console.error('Error:', error);
        });
    }

    // View transactions from table
    document.querySelectorAll('.view-transactions').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const transactionModalLabel = document.getElementById('transactionModalLabel');
            loadTransactions(studentId, transactionModalLabel);
        });
    });

    // Reset transaction modal on close
    document.getElementById('transactionModal').addEventListener('hidden.bs.modal', function () {
        const transactionTableBody = document.getElementById('transactionTableBody');
        const noTransactions = document.getElementById('noTransactions');
        const transactionModalLabel = document.getElementById('transactionModalLabel');
        const loadingSpinner = document.getElementById('loadingSpinner');

        transactionTableBody.innerHTML = '';
        noTransactions.style.display = 'none';
        transactionModalLabel.textContent = 'Payment History';
        loadingSpinner.style.display = 'none';
    });
});
</script>
@endsection