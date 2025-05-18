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
            <h2>Archived Sections</h2>
            <p style="font-size: 18px; color:#555 !important;">View and manage archived sections</p>
        </div>
        <div>
            <a href="{{ route('section.index') }}">
                <button class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-list"></i> Active Sections
                </button>
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
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover" style="cursor: pointer;">
                    <thead>
                        <tr>
                            <th scope="col" class="p-1 text-center align-middle">#</th>
                            <th scope="col" class="p-1 text-center align-middle">Section Name</th>
                            <th scope="col" class="p-1 text-center align-middle">Grade Level</th>
                            <th scope="col" class="p-1 text-center align-middle">Strand</th>
                            <th scope="col" class="p-1 text-center align-middle">Track</th>
                            <th scope="col" class="p-1 text-center align-middle">Room</th>
                            <th scope="col" class="p-1 text-center align-middle">Capacity</th>
                            <th scope="col" class="p-1 text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $section->section_name }}</td>
                            <td class="text-center">{{ $section->grade_level }}</td>
                            <td class="text-center">{{ $section->strand->strand_name }}</td>
                            <td class="text-center">{{ $section->track->track_name }}</td>
                            <td class="text-center">{{ $section->room }}</td>
                            <td class="text-center">{{ $section->capacity }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="action-btn text-success custom-modal-toggle"
                                        data-section-id="{{ $section->id }}"
                                        data-section-name="{{ $section->section_name }}"
                                        aria-label="Restore section {{ $section->section_name }}">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Custom Restore Confirmation Modal -->
                        <div class="custom-modal" id="customDeleteModal{{ $section->id }}"
                            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center; padding: 20px;">
                            <div
                                style="background: white; border-radius: 8px; width: 90%; max-width: 500px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <div
                                    style="background: #28a745; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
                                    <h5 style="margin: 0;">Confirm Restore</h5>
                                    <button type="button" class="custom-modal-close"
                                        data-section-id="{{ $section->id }}"
                                        style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;"
                                        aria-label="Close restore confirmation modal">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div style="text-align: center; font-size:50px;">
                                    <i class="fa-solid fa-rotate-left" style="color: #28a745;"></i>
                                </div>
                                <div style="padding: 15px;">
                                    Are you sure you want to restore the section
                                    <strong>{{ $section->section_name }}</strong>? This will make the section active again.
                                </div>
                                <div style="padding: 10px; display: flex; justify-content: flex-end; gap: 5px;">
                                    <button type="button" class="custom-modal-close btn text-secondary"
                                        data-section-id="{{ $section->id }}" style="padding: 8px 16px; cursor: pointer;"
                                        aria-label="Cancel restore section">Cancel</button>
                                    <form action="{{ route('section.restore', $section->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            style="padding: 8px 16px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;"
                                            aria-label="Confirm restore section">Restore</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No archived sections found.</td>
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

        // Modal toggle functionality
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
    });
</script>
@endsection 