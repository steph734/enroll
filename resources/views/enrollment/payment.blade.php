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
    $totalstudent = \App\Models\Student::where('paymentstatus', 'unpaid')->count();
@endphp
<div class="col-md-4">
    <div class="p-3 m-1 text-center card">
        <div class="card-body">
            <i class="fa-solid fa-user-times fa-2x text-danger"></i>
            <h5 class="mt-2 card-title">{{ $totalstudent }}</h5>
            <p class="card-text">Unpaid Student Count</p>
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
                            <button class="tab" data-filter="unpaid">Unpaid</button>
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

                            <a href="{{ route('payments.create') }}">
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
                                <th scope="col" class="align-middle">Student ID</th>
                                <th scope="col" class="align-middle">Full Name</th>
                                <th scope="col" class="align-middle">Grade & Section</th>
                                <th scope="col" class="align-middle">PaymentMethod</th>
                                <th scope="col" class="align-middle">Amount Paid</th>
                                <th scope="col" class="align-middle">Balance</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle">Payment Date</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTable">
                            @forelse(\App\Models\Student::all() as $student)
                            <tr class="payment-row" data-status="{{ $student->status }}">
                                <td>{{ $student->studentid }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->grade_level }} -
                                    {{ $student->section ? $student->section->code : 'N/A' }}
                                </td>
                                <td>{{($student->payment_method) }}</td>
                                <td>₱{{ number_format($student->downpayment, 2) }}</td>
                                <td>₱{{ number_format($student->balance, 2) }}</td>
                                <td>{{ $student->paymentstatus }}</td>
                                <td>{{ $student->payment_date ? \Carbon\Carbon::parse($student->payment_date)->format('m/d/Y') : 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ route('payments.show', $student) }}" class="btn" title="View">
                                        <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                    </a>
                                    <a href="{{ route('payments.edit', $student) }}" class="btn" title="Edit">
                                        <i class="fa-solid fa-pen-to-square" style="color:#ffc107; font-size: 18px;"
                                            onmouseover="this.style.color='#e0a800'"
                                            onmouseout="this.style.color='#ffc107'"></i>
                                    </a>
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
                    const aAmount = parseFloat(a.cells[3].textContent.replace('₱', '').replace(',',
                        ''));
                    const bAmount = parseFloat(b.cells[3].textContent.replace('₱', '').replace(',',
                        ''));
                    return aAmount - bAmount;
                } else if (sortValue === 'amount-due-desc') {
                    const aAmount = parseFloat(a.cells[3].textContent.replace('₱', '').replace(',',
                        ''));
                    const bAmount = parseFloat(b.cells[3].textContent.replace('₱', '').replace(',',
                        ''));
                    return bAmount - aAmount;
                }
                return 0;
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });
</script>
@endsection