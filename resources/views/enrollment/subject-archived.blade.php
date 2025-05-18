@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subject.css') }}">
<style>
    .action-btn {
        padding: 0.25rem 0.25rem;
        margin: 0 2px;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <div class="d-flex justify-content-between mb-1">
        <div>
            <h2>Archived Subjects</h2>
            <p style="font-size: 18px; color:#555 !important;">View and manage archived subjects</p>
        </div>
        <div>
            <a href="{{ route('subject.index') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-list"></i> Active Subjects
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger p-1 mb-3">
        <i class="fa-solid fa-circle-exclamation"></i>
        <strong>Whoops!</strong> There were some problems with your input.
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success p-1 mb-3">
        <strong><i class="fa-solid fa-circle-check"></i> Success!</strong> {{ session('success') }}
    </div>
    @endif

    <div class="card p-3">
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-between">
                <div class="d-flex gap-2">
                    <!-- Strand Filter Dropdown -->
                    <div class="dropdown">
                        <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-filter"></i> {{ $strand ?? 'Filter by Strand' }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ !$strand ? 'active' : '' }}"
                                    href="{{ route('subject.archived', ['search' => $search]) }}">All Strands</a></li>
                            @foreach ($strands as $id => $strandName)
                            <li>
                                <a class="dropdown-item {{ $strand && str_contains(strtolower($strandName), strtolower($strand)) ? 'active' : '' }}"
                                    href="{{ route('subject.archived', ['strand' => substr(strtolower($strandName), 0, strpos(strtolower($strandName), '(') - 1), 'sort' => $sort, 'search' => $search]) }}">
                                    {{ $strandName }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Sort Order Dropdown -->
                    <div class="dropdown">
                        <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-arrow-down-wide-short"></i>
                            {{ $sort ? ucfirst(str_replace('-', ' ', $sort)) : 'Sort' }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ $sort === 'newest' ? 'active' : '' }}"
                                    href="{{ route('subject.archived', ['strand' => $strand, 'sort' => 'newest', 'search' => $search]) }}">Newest-Oldest</a>
                            </li>
                            <li><a class="dropdown-item {{ $sort === 'oldest' ? 'active' : '' }}"
                                    href="{{ route('subject.archived', ['strand' => $strand, 'sort' => 'oldest', 'search' => $search]) }}">Oldest-Newest</a>
                            </li>
                            <li><a class="dropdown-item {{ $sort === 'a-z' ? 'active' : '' }}"
                                    href="{{ route('subject.archived', ['strand' => $strand, 'sort' => 'a-z', 'search' => $search]) }}">A-Z</a>
                            </li>
                            <li><a class="dropdown-item {{ $sort === 'z-a' ? 'active' : '' }}"
                                    href="{{ route('subject.archived', ['strand' => $strand, 'sort' => 'z-a', 'search' => $search]) }}">Z-A</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <form action="{{ route('subject.archived') }}" method="GET" id="searchForm">
                        <div class="search-container-dash">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" placeholder="Search..." id="searchInput"
                                class="form-control" value="{{ $search ?? '' }}">
                            @if($search)
                            <button type="button" onclick="clearSearch()" aria-label="Clear search"
                                style="right: 30px; padding: 30px;">
                                <i class="fa-solid fa-times"></i>
                            </button>
                            @endif
                        </div>
                        <input type="hidden" name="strand" value="{{ $strand ?? '' }}">
                        <input type="hidden" name="sort" value="{{ $sort ?? '' }}">
                    </form>
                </div>
            </div>
            <hr>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover" style="cursor: pointer;">
                    <thead>
                        <tr>
                            <th scope="col" class="p-1 text-center align-middle">#</th>
                            <th scope="col" class="p-1 text-center align-middle">Subject Code</th>
                            <th scope="col" class="p-1 text-center align-middle">Subject Name</th>
                            <th scope="col" class="p-1 text-center align-middle">Description</th>
                            <th scope="col" class="p-1 text-center align-middle">Strand</th>
                            <th scope="col" class="p-1 text-center align-middle">Track</th>
                            <th scope="col" class="p-1 text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $subject->subject_code }}</td>
                            <td class="text-center">{{ $subject->subject_name }}</td>
                            <td class="text-center">{{ $subject->description }}</td>
                            <td class="text-center">{{ $subject->strand->strand_name }}</td>
                            <td class="text-center">{{ $subject->track->track_name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="action-btn text-success custom-modal-toggle"
                                        data-subject-id="{{ $subject->id }}"
                                        data-subject-name="{{ $subject->subject_name }}"
                                        aria-label="Restore subject {{ $subject->subject_name }}">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Custom Restore Confirmation Modal -->
                        <div class="custom-modal" id="customDeleteModal{{ $subject->id }}"
                            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center; padding: 20px;">
                            <div
                                style="background: white; border-radius: 8px; width: 90%; max-width: 500px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <div
                                    style="background: #28a745; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
                                    <h5 style="margin: 0;">Confirm Restore</h5>
                                    <button type="button" class="custom-modal-close"
                                        data-subject-id="{{ $subject->id }}"
                                        style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;"
                                        aria-label="Close restore confirmation modal">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div style="text-align: center; font-size:50px;">
                                    <i class="fa-solid fa-rotate-left" style="color: #28a745;"></i>
                                </div>
                                <div style="padding: 15px;">
                                    Are you sure you want to restore the subject
                                    <strong>{{ $subject->subject_name }}</strong>? This will make the subject active again.
                                </div>
                                <div style="padding: 10px; display: flex; justify-content: flex-end; gap: 5px;">
                                    <button type="button" class="custom-modal-close btn text-secondary"
                                        data-subject-id="{{ $subject->id }}" style="padding: 8px 16px; cursor: pointer;"
                                        aria-label="Cancel restore subject">Cancel</button>
                                    <form action="{{ route('subject.restore', $subject->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            style="padding: 8px 16px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;"
                                            aria-label="Confirm restore subject">Restore</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No archived subjects found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.custom-modal-toggle');
        const closeButtons = document.querySelectorAll('.custom-modal-close');
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const clearButton = document.querySelector('.search-container-dash button');

        // Modal toggle functionality
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subjectId = this.getAttribute('data-subject-id');
                const modal = document.getElementById(`customDeleteModal${subjectId}`);
                if (modal) {
                    modal.classList.add('show');
                }
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subjectId = this.getAttribute('data-subject-id');
                const modal = document.getElementById(`customDeleteModal${subjectId}`);
                if (modal) {
                    modal.classList.remove('show');
                }
            });
        });

        document.querySelectorAll('.custom-modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('show');
                }
            });
        });

        // Submit form on input change
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });

        // Clear search functionality
        window.clearSearch = function() {
            searchInput.value = '';
            searchForm.submit();
        };

        if (clearButton) {
            clearButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                clearSearch();
            });
        }
    });
</script>
@endsection 