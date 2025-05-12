@extends('layouts.app')

@section('title', 'Edit Subject')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subject.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    a {
        text-decoration: none !important;
    }

    .subject-content {
        margin: 10px !important;
    }

    .card {
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        height: 100vh !important;
    }

    .dropdown-item i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <div class="container">
        <div class="card p-3">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h2>Edit Subject</h2>
                    <p style="font-size:14px; color:#555 !important;">
                        Update the subject details below. Modify the subject name, description, track, strand, or any
                        other relevant information.
                    </p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="{{ route('subject.index') }}" class="p-1"><i class="fa-solid fa-house"></i> <span
                            class="text-muted">Home</span></a>
                    <a href="{{ route('subject.index') }}" class="p-1"><i class="fa-solid fa-arrow-left"></i> <span
                            class="text-muted">Return</span></a>
                </div>
            </div>
            <hr>

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
                {{ session('success') }}
            </div>
            @endif

            <div class="col-md-8">
                <form action="{{ route('subject.update', $subject->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 d-flex gap-2">
                        <div class="p-1">
                            <label for="track_id" class="form-label">Track</label><br>
                            <div class="dropdown">
                                <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" id="trackDropdownBtn">
                                    <i class="fa-solid fa-signs-post"></i> <span class="track-label">Select a
                                        Track</span>
                                </a>
                                <input type="hidden" name="track_id" id="track_id"
                                    value="{{ old('track_id', $subject->track_id) }}" required>
                                <ul class="dropdown-menu" id="trackDropdown">
                                    @foreach($tracks as $track)
                                    <li><a class="dropdown-item track-option" data-value="{{ $track->id }}" href="#">
                                            @php
                                            $icon = 'fa-question';
                                            $trackNameLower = strtolower($track->track_name);
                                            switch (true) {
                                            case str_contains($trackNameLower, 'academic'):
                                            $icon = 'fa-graduation-cap';
                                            break;
                                            case str_contains($trackNameLower, 'tvl'):
                                            $icon = 'fa-tools';
                                            break;
                                            case str_contains($trackNameLower, 'sports'):
                                            $icon = 'fa-basketball';
                                            break;
                                            case str_contains($trackNameLower, 'arts'):
                                            $icon = 'fa-brush';
                                            break;
                                            }
                                            @endphp
                                            <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                                            {{ $track->track_name }}
                                        </a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('track_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1">
                            <label for="strand_id" class="form-label">Strand</label><br>
                            <div class="dropdown">
                                <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" id="strandDropdownBtn">
                                    <i class="fa-solid fa-person"></i> <span class="strand-label">Select a Strand</span>
                                </a>
                                <input type="hidden" name="strand_id" id="strand_id"
                                    value="{{ old('strand_id', $subject->strand_id) }}" required>
                                <ul class="dropdown-menu" id="strandDropdown">
                                    @foreach($strands as $strand)
                                    <li><a class="dropdown-item strand-option" data-value="{{ $strand->id }}" href="#">
                                            @php
                                            $icon = 'fa-question';
                                            $strandNameLower = strtolower($strand->strand_name);
                                            switch (true) {
                                            case str_contains($strandNameLower, 'accountancy') ||
                                            str_contains($strandNameLower, 'abm'):
                                            $icon = 'fa-briefcase';
                                            break;
                                            case str_contains($strandNameLower, 'science') ||
                                            str_contains($strandNameLower, 'stem'):
                                            $icon = 'fa-flask';
                                            break;
                                            case str_contains($strandNameLower, 'humanities') ||
                                            str_contains($strandNameLower, 'humss'):
                                            $icon = 'fa-book';
                                            break;
                                            case str_contains($strandNameLower, 'general academic') ||
                                            str_contains($strandNameLower, 'gas'):
                                            $icon = 'fa-pencil';
                                            break;
                                            case str_contains($strandNameLower, 'agri-fishery'):
                                            $icon = 'fa-wheat-awn';
                                            break;
                                            case str_contains($strandNameLower, 'home economics'):
                                            $icon = 'fa-house';
                                            break;
                                            case str_contains($strandNameLower, 'information') ||
                                            str_contains($strandNameLower, 'ict'):
                                            $icon = 'fa-laptop';
                                            break;
                                            case str_contains($strandNameLower, 'industrial arts'):
                                            $icon = 'fa-hammer';
                                            break;
                                            case str_contains($strandNameLower, 'sports'):
                                            $icon = 'fa-basketball';
                                            break;
                                            case str_contains($strandNameLower, 'arts'):
                                            $icon = 'fa-brush';
                                            break;
                                            }
                                            @endphp
                                            <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                                            {{ $strand->strand_name }}
                                        </a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('strand_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject_code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control p-1" id="subject_code" name="subject_code"
                            value="{{ old('subject_code', $subject->subject_code) }}" required>
                        @error('subject_code')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control p-1" id="subject_name" name="subject_name"
                            value="{{ old('subject_name', $subject->subject_name) }}" required>
                        @error('subject_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control p-1" id="description" name="description" rows="4"
                            placeholder="Enter subject description">{{ old('description', $subject->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary btn-sm p-1">
                            <i class="fa-solid fa-floppy-disk"></i> Save Changes
                        </button>
                        <a href="{{ route('subject.index') }}"
                            class="btn btn-outline-primary ms-2 btn-sm p-1">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trackDropdownItems = document.querySelectorAll('.track-option');
        const strandDropdownItems = document.querySelectorAll('.strand-option');
        const trackHiddenInput = document.getElementById('track_id');
        const strandHiddenInput = document.getElementById('strand_id');
        const trackDropdownBtn = document.getElementById('trackDropdownBtn');
        const strandDropdownBtn = document.getElementById('strandDropdownBtn');
        const trackLabel = trackDropdownBtn.querySelector('.track-label');
        const strandLabel = strandDropdownBtn.querySelector('.strand-label');

        // Initialize the dropdown labels based on the subject's current track and strand
        if (trackHiddenInput.value) {
            const selectedTrack = document.querySelector(`.track-option[data-value="${trackHiddenInput.value}"]`);
            if (selectedTrack) {
                trackLabel.textContent = selectedTrack.textContent.replace(/.*<\/i>/, '').trim();
            }
        }
        if (strandHiddenInput.value) {
            const selectedStrand = document.querySelector(
                `.strand-option[data-value="${strandHiddenInput.value}"]`);
            if (selectedStrand) {
                strandLabel.textContent = selectedStrand.textContent.replace(/.*<\/i>/, '').trim();
            }
        }

        // Handle track selection
        trackDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();

                trackHiddenInput.value = value;
                trackLabel.textContent = text;
            });
        });

        // Handle strand selection
        strandDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();

                strandHiddenInput.value = value;
                strandLabel.textContent = text;
            });
        });
    });
</script>
@endsection
@endsection