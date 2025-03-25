@extends('layouts.app')

@section('title', 'Payment')
@section('styles')
<link rel="stylesheet" href="{{asset('css/payments.css')}}">
@endsection
@section('content')
<div class="payment-content">
    <!-- Summary Cards -->
    <div class="mb-3 row">
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-money-bill-wave fa-2x text-success"></i>
                    <h5 class="mt-2 card-title">₱50,000</h5>
                    <p class="card-text">Total Payments Collected</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-balance-scale fa-2x text-warning"></i>
                    <h5 class="mt-2 card-title">₱30,000</h5>
                    <p class="card-text">Total Outstanding Balance</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 m-1 text-center card">
                <div class="card-body">
                    <i class="fa-solid fa-user-times fa-2x text-danger"></i>
                    <h5 class="mt-2 card-title">13</h5>
                    <p class="card-text">Unpaid Student Count</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Section with Search -->
    <div class="mb-3 row">
        <div class="row">
            <div class="p-3 card card-header-payment">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="card-title d-flex align-items-center">
                            <h5>List of Payments</h5>
                            <form action="" id="searchForm" style="margin-left: 230px !important;">
                                <div class="search-container-dash">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" placeholder="Search..." id="searchInput">
                                    <!-- Suggestions dropdown -->
                                    <div id="suggestions"
                                        style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="mt-3 filters d-flex justify-content-between align-items-center">
                        <!-- Tabs for filtering by payment status -->
                        <div class="gap-3 tabs d-flex">
                            <button class="tab active">ALL Students</button>
                            <button class="tab">Paid</button>
                            <button class="tab">Unpaid</button>
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
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle">StudentID</th>
                                <th scope="col" class="align-middle">Full Name</th>
                                <th scope="col" class="align-middle">Grade & Section</th>
                                <th scope="col" class="align-middle">Amount Due</th>
                                <th scope="col" class="align-middle">Amount Paid</th>
                                <th scope="col" class="align-middle">Balance</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle">Payment Date</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="align-middle">202501</th>
                                <td class="align-middle">Juan Dela Cruz</td>
                                <td class="align-middle">11 - STEM A</td>
                                <td class="align-middle">₱5,000</td>
                                <td class="align-middle">₱2,000</td>
                                <td class="align-middle">₱2,000</td>
                                <td class="align-middle">Partial</td>
                                <td class="align-middle">02/10/2025</td>
                                <td class="align-middle">
                                    <button class="btn"><i class="fa-solid fa-eye"
                                            style="color:#305cde; font-size: 18px;"></i></button>
                                    <button class="btn "><i class="fa-solid fa-edit"
                                            style="color:#305cde; font-size: 18px;"></i></button>
                                </td>
                            </tr>
                            <!-- Add more rows dynamically using PHP if needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection