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
    $totalPayments = $students->sum('total_paid');
    $totalBalance = $students->sum('balance');
    $totalPaidStudents = $students->where('balance', 0)->count();
    @endphp
    <div class="mb-3 row">
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-bill-wave fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalPayments, 2) }}</h5>
                    <p class="card-text">Total Payments Collected</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-balance-scale fa-2x text-warning"></i>
                    <h5 class="mt-2 card-title">₱{{ number_format($totalBalance, 2) }}</h5>
                    <p class="card-text">Total Outstanding Balance</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-user-check fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">{{ $totalPaidStudents }}</h5>
                    <p class="card-text">Fully Paid Students</p>
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
                            <button class="tab active" data-filter="all">All Students</button>
                            <button class="tab" data-filter="fullypaid">Fully Paid</button>
                            <button class="tab" data-filter="partiallypaid">Partially Paid</button>
                            <button class="tab" data-filter="unpaid">Unpaid</button>
                        </div>
                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select form-select-sm" id="gradeLevelFilter" style="width: 150px;">
                                <option value="">All Grade Levels</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                            <select class="form-select form-select-sm" id="sortBy" style="width: 150px;">
                                <option value="">Sort By</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="amount-paid-asc">Total Paid (Low to High)</option>
                                <option value="amount-paid-desc">Total Paid (High to Low)</option>
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
                                    <th scope="col" class="align-middle">Total Amount Paid</th>
                                    <th scope="col" class="align-middle">Balance</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody id="paymentsTable">
                                @forelse($students as $student)
                                <tr class="payment-row" data-status="{{ strtolower($student->status) }}"
                                    data-grade-level="{{ $student->grade_level }}"
                                    data-amount-paid="{{ $student->total_paid }}"
                                    data-balance="{{ $student->balance }}">
                                    <td>{{ $student->studentid }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->grade_level }} -
                                        {{ $student->section ? $student->section->code : 'N/A' }}
                                    </td>
                                    <td>₱{{ number_format($student->total_paid, 2) }}</td>
                                    <td>₱{{ number_format($student->balance, 2) }}</td>
                                    <td>{{ $student->status }}</td>
                                    <td>
                                        <a href="{{ route('payments.history', $student->id) }}">
                                            <button class="btn" title="View Payment History">
                                                <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No students found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
            const sortValue = sortBy.value;

            let filteredRows = Array.from(paymentRows);

            // Filter rows
            filteredRows = filteredRows.filter(row => {
                const studentId = row.cells[0].textContent.toLowerCase();
                const fullName = row.cells[1].textContent.toLowerCase();
                const gradeSection = row.cells[2].textContent.toLowerCase();
                const status = row.getAttribute('data-status');
                const gradeLevel = row.getAttribute('data-grade-level');

                const matchesSearch = !searchTerm ||
                    studentId.includes(searchTerm) ||
                    fullName.includes(searchTerm) ||
                    gradeSection.includes(searchTerm);

                const matchesStatus = selectedStatus === 'all' ||
                    status === selectedStatus;

                const matchesGradeLevel = !selectedGradeLevel || gradeLevel === selectedGradeLevel;

                return matchesSearch && matchesStatus && matchesGradeLevel;
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
        sortBy.addEventListener('change', applyFilters);

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            gradeLevelFilter.value = '';
            sortBy.value = '';
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelector('.tab[data-filter="all"]').classList.add('active');
            suggestionsDiv.style.display = 'none';
            applyFilters();
        });
    });
</script>
@endsection