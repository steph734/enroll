@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/section.css') }}">
<style>
    /* Reduce padding on action buttons to bring icons closer */
    .action-btn {
        padding: 0.25rem 0.25rem;
        /* Reduced padding */
        margin: 0 2px;
        /* Minimal margin to prevent overlap */
    }
</style>
@endsection

@section('content')
<div class="subject-content">

    <div class="d-flex justify-content-between mb-1">
        <div>
            <h2>List of Sections</h2>
            <p style="font-size: 18px; color:#555 !important;">For 1st Semester, Class of 2024-2025</p>
        </div>
        <div>
            <a href="{{ route('subject.index') }}" style="text-decoration: none !important;"><button
                    class="btn btn-sm text-dark p-1" style="font-size: 14px;">
                    <i class="fa-solid fa-book"></i> Subjects
                </button>
            </a>
            <button class="btn btn-sm btn-primary p-1" style="font-size: 14px;">
                <i class="fa-solid fa-school"></i> Sections
            </button>
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
                    <a href="{{ route('section.create') }}">
                        <button class="btn btn-primary p-1"
                            style="font-size: 14px !important; text-decoration: none !important;">
                            <i class="fa fa-solid fa-plus"></i> Add Section
                        </button>
                    </a>
                    <a href="{{ route('section.archived') }}">
                        <button class="btn btn-warning p-1"
                            style="font-size: 14px !important; text-decoration: none !important;">
                            <i class="fa-solid fa-box-archive"></i> Archived Sections
                        </button>
                    </a>
                    <!-- Strand Filter Dropdown -->
                    <div class="dropdown">
                        <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-filter"></i> {{ $strand ?? 'Filter by Strand' }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ !$strand ? 'active' : '' }}"
                                    href="{{ route('section.index', ['search' => $search]) }}">All Strands</a></li>
                            @foreach ($strands as $id => $strandName)
                            <li>
                                <a class="dropdown-item {{ $strand && str_contains(strtolower($strandName), strtolower($strand)) ? 'active' : '' }}"
                                    href="{{ route('section.index', ['strand' => substr(strtolower($strandName), 0, strpos(strtolower($strandName), '(') - 1), 'sort' => $sort, 'search' => $search]) }}">
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
                                    href="{{ route('section.index', ['strand' => $strand, 'sort' => 'newest', 'search' => $search]) }}">Newest-Oldest</a>
                            </li>
                            <li><a class="dropdown-item {{ $sort === 'oldest' ? 'active' : '' }}"
                                    href="{{ route('section.index', ['strand' => $strand, 'sort' => 'oldest', 'search' => $search]) }}">Oldest-Newest</a>
                            </li>
                            <li><a class="dropdown-item {{ $sort === 'a-z' ? 'active' : '' }}"
                                    href="{{ route('section.index', ['strand' => $strand, 'sort' => 'a-z', 'search' => $search]) }}">A-Z</a>
                            </li>
                            <li><a class="dropdown-item {{ $sort === 'z-a' ? 'active' : '' }}"
                                    href="{{ route('section.index', ['strand' => $strand, 'sort' => 'z-a', 'search' => $search]) }}">Z-A</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <form action="{{ route('section.index') }}" method="GET" id="searchForm">
                        <div class="search-container-dash">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" placeholder="Search..." id="searchInput"
                                class="form-control" value="{{ $search ?? '' }}">
                            @if($search)
                            <button type="button" onclick="clearSearch()" aria-label="Clear search">
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
                            <th scope="col" class="p-1 text-center align-middle"></th>
                            <th scope="col" class="p-1 text-center align-middle">Section Name</th>
                            <th scope="col" class="p-1 text-center align-middle">Description</th>
                            <th scope="col" class="p-1 text-center align-middle">School Year</th>
                            <th scope="col" class="p-1 text-center align-middle">Grade Level</th>
                            <th scope="col" class="p-1 text-center align-middle">Status</th>
                            <th scope="col" class="p-1 text-center align-middle">Adviser</th>
                            <th scope="col" class="p-1 text-center align-middle">Room</th>
                            <th scope="col" class="p-1 text-center align-middle">Strand</th>
                            <th scope="col" class="p-1 text-center align-middle">Track</th>
                            <th scope="col" class="p-1 text-center align-middle">Capacity</th>
                            <th scope="col" class="p-1 text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                        <tr>
                            <td class="text-center p-2"><a href="{{ route('sectionline.index',$section->id) }}"><i
                                        class="fa-solid fa-angle-right"></i></td>
                            <td class="text-center">{{ $section->section_name }}</td>
                            <td class="text-center">{{ $section->description ?? '-' }}</td>
                            <td class="text-center">{{ $section->school_year ?? '-' }}</td>
                            <td class="text-center">{{ $section->GradeLevel ?? '-' }}</td>
                            <td class="text-center">{{ ucfirst($section->status) }}</td>
                            <td class="text-center">{{ $section->adviser ?? '-' }}</td>
                            <td class="text-center">{{ $section->room ?? '-' }}</td>
                            <td class="text-center">{{ $section->strand->strand_name }}</td>
                            <td class="text-center">{{ $section->track->track_name }}</td>
                            <td class="text-center">
                                {{ $section->sectionLines->count() ?? '0'}}/{{ $section->capacity }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('section.edit', $section->id) }}"
                                        class="action-btn text-primary" aria-label="Edit section">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="action-btn text-warning custom-modal-toggle"
                                        data-section-id="{{ $section->id }}"
                                        data-section-name="{{ $section->section_name }}"
                                        aria-label="Archive section {{ $section->section_name }}">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Custom Archive Confirmation Modal -->
                        <div class="custom-modal" id="customDeleteModal{{ $section->id }}"
                            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center; padding: 20px;">
                            <div
                                style="background: white; border-radius: 8px; width: 90%; max-width: 500px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <div
                                    style="background: #ffc107; color: black; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
                                    <h5 style="margin: 0;">Confirm Archive</h5>
                                    <button type="button" class="custom-modal-close"
                                        data-section-id="{{ $section->id }}"
                                        style="background: none; border: none; color: black; font-size: 20px; cursor: pointer;"
                                        aria-label="Close archive confirmation modal">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div style="text-align: center; font-size:50px;">
                                    <i class="fa-solid fa-box-archive" style="color: #ffc107;"></i>
                                </div>
                                <div style="padding: 15px;">
                                    Are you sure you want to archive the section
                                    <strong>{{ $section->section_name }}</strong>? This section will be moved to the archive and can be restored later if needed.
                                </div>
                                <div style="padding: 10px; display: flex; justify-content: flex-end; gap: 5px;">
                                    <button type="button" class="custom-modal-close btn text-secondary"
                                        data-section-id="{{ $section->id }}" style="padding: 8px 16px; cursor: pointer;"
                                        aria-label="Cancel archive section">Cancel</button>
                                    <form action="{{ route('section.archive', $section->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            style="padding: 8px 16px; border: none; border-radius: 4px; background: #ffc107; color: black; cursor: pointer;"
                                            aria-label="Confirm archive section">Archive</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">No sections found.</td>
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

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const sectionId = this.getAttribute('data-section-id');
                const modal = document.getElementById(`customDeleteModal${sectionId}`);
                if (modal) {
                    modal.classList.add('show');
                }
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const sectionId = this.getAttribute('data-section-id');
                const modal = document.getElementById(`customDeleteModal${sectionId}`);
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

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });

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