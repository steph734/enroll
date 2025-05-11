@extends('layouts.app')

@section('title', 'Accounts')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endsection

@section('content')
<div class="accounts-content">
    <div class="mb-3 row">
        <div class="row row-header-account">
            <h2>Accounts</h2>
            <p style="font-size: 18px; color:#555 !important;">Manage Admin Accounts</p>
            <div class="p-3 card card-header-account sticky-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <!-- Optional: Add total accounts count if needed -->
                            <!-- <p style="font-size: 14px;">Total Accounts: {{ \App\Models\User::count() }}</p> -->
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
                            <button class="tab active" data-filter="all">All Accounts</button>
                            <button class="tab" data-filter="Active">Active</button>
                            <button class="tab" data-filter="Inactive">Inactive</button>
                        </div>

                        <div class="gap-2 dropdowns d-flex">
                            <input type="text" class="form-control filter-input" id="adminIdFilter" placeholder="Admin ID" style="width: 150px;">
                            <input type="text" class="form-control filter-input" id="usernameFilter" placeholder="Username" style="width: 150px;">
                            <select class="form-select filter-select" id="statusFilter" style="width: 150px;">
                                <option value="">All Statuses</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <button class="btn btn-outline-dark btn-sm p-1" id="clearFilters">
                                <i class="fa-solid fa-eraser"></i> Clear Filters
                            </button>
                        </div>

                        <a href="{{ route('accounts.create') }}">
                            <button class="btn btn-primary add-account"><i class="fa-solid fa-plus"></i> Add Account</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="p-3 card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th scope="col" class="p-1 text-center align-middle">ID</th>
                                <th scope="col" class="p-1 text-center align-middle">Username</th>
                                <th scope="col" class="p-1 text-center align-middle">Status</th>
                                <th scope="col" class="p-1 text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody id="accountsTable">
                            @forelse(\App\Models\User::all() as $account)
                            <tr class="account-row" data-status="{{ $account->status }}">
                                <td class="text-center">{{ $account->id }}</td>
                                <td class="text-center">{{ $account->username }}</td>
                                <td class="text-center">{{ $account->status }}</td>
                                <td class="text-center">
                                    <form action="" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-{{ $account->status == 'Active' ? 'danger' : 'success' }} btn-sm">
                                            {{ $account->status == 'Active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                        <input type="hidden" name="status" value="{{ $account->status == 'Active' ? 'Inactive' : 'Active' }}">
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center">No accounts found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('suggestions');
        const accountRows = document.querySelectorAll('.account-row');
        const adminIdFilter = document.getElementById('adminIdFilter');
        const usernameFilter = document.getElementById('usernameFilter');
        const statusFilter = document.getElementById('statusFilter');
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

        // Apply client-side filters
        const applyFilters = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = document.querySelector('.tab.active').getAttribute('data-filter');
            const adminId = adminIdFilter.value.toLowerCase();
            const username = usernameFilter.value.toLowerCase();
            const status = statusFilter.value;

            accountRows.forEach(row => {
                const id = row.cells[0].textContent.toLowerCase();
                const usernameText = row.cells[1].textContent.toLowerCase();
                const rowStatus = row.getAttribute('data-status');

                const matchesSearch = !searchTerm || id.includes(searchTerm) || usernameText.includes(searchTerm);
                const matchesTab = selectedStatus === 'all' || rowStatus === selectedStatus;
                const matchesAdminId = !adminId || id.includes(adminId);
                const matchesUsername = !username || usernameText.includes(username);
                const matchesStatus = !status || rowStatus === status;

                row.style.display = matchesSearch && matchesTab && matchesAdminId && matchesUsername && matchesStatus ? '' : 'none';
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

            const matches = Array.from(accountRows).filter(row => {
                const id = row.cells[0].textContent.toLowerCase();
                const username = row.cells[1].textContent.toLowerCase();
                return id.includes(searchTerm) || username.includes(searchTerm);
            });

            if (matches.length) {
                matches.slice(0, 5).forEach(row => {
                    const suggestion = document.createElement('div');
                    suggestion.classList.add('p-2');
                    suggestion.textContent = `${row.cells[0].textContent} - ${row.cells[1].textContent}`;
                    suggestion.addEventListener('click', () => {
                        searchInput.value = row.cells[1].textContent;
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

        // AJAX table update
        const updateTable = () => {
            const adminId = adminIdFilter.value;
            const username = usernameFilter.value;
            const status = statusFilter.value;
            const searchQuery = searchInput.value;

            $.ajax({
                url: '{{ route('accounts.index') }}',
                method: 'GET',
                data: {
                    admin_id: adminId,
                    username: username,
                    status: status,
                    search: searchQuery
                },
                success: function(data) {
                    $('#accountsTable').html($(data).find('#accountsTable').html());
                    // Re-attach event listeners to new rows
                    accountRows = document.querySelectorAll('.account-row');
                    applyFilters();
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        };

        // Event listeners
        searchInput.addEventListener('input', () => {
            updateSuggestions();
            applyFilters();
            debounce(updateTable, 500)();
        });

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        adminIdFilter.addEventListener('input', () => {
            applyFilters();
            debounce(updateTable, 500)();
        });
        usernameFilter.addEventListener('input', () => {
            applyFilters();
            debounce(updateTable, 500)();
        });
        statusFilter.addEventListener('change', () => {
            applyFilters();
            debounce(updateTable, 500)();
        });

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            adminIdFilter.value = '';
            usernameFilter.value = '';
            statusFilter.value = '';
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelector('.tab[data-filter="all"]').classList.add('active');
            suggestionsDiv.style.display = 'none';
            applyFilters();
            updateTable();
        });
    });
</script>
@endsection