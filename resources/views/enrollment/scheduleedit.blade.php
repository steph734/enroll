@extends('layouts.app')

@section('styles')
<style>
    .card {
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        min-height: 100vh !important;
    }

    .dropdown-item i {
        margin-right: 8px;
    }

    .debug-section {
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .note {
        font-size: 12px;
        font-style: italic;
        color: #666;
        margin-top: 5px;
    }

    .day-checkboxes {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .teacher-assigned {
        color: #28a745;
        font-size: 12px;
        margin-top: 5px;
    }

    .autocomplete-container {
        position: relative;
    }

    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }

    .autocomplete-suggestions.show {
        display: block;
    }

    .autocomplete-suggestions .suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    .autocomplete-suggestions .suggestion-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="schedule-content">
    <div class="card p-3">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2>Edit Schedule</h2>
                <p style="font-size:14px; color:#555 !important;">
                    Update the class schedule details, including subject, timing, and strand.
                </p>
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

        <form action="{{ route('schedule.update', $schedule) }}" method="POST" class="mt-4" id="scheduleForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="subject_search" class="form-label">Subject Code</label>
                        <div class="autocomplete-container">
                            <input type="text" class="form-control p-1" id="subject_search"
                                placeholder="Type subject code or name..."
                                value="{{ old('subject_search', $schedule->code . ' - ' . $schedule->title) }}"
                                class="@error('code') is-invalid @enderror">
                            <input type="hidden" name="code" id="code" value="{{ old('code', $schedule->code) }}"
                                class="@error('code') is-invalid @enderror" required>
                            <div class="autocomplete-suggestions" id="subjectSuggestions">
                                @foreach ($subjects as $subject)
                                <div class="suggestion-item" data-value="{{ $subject->subject_code }}"
                                    data-title="{{ $subject->subject_name }}"
                                    data-description="{{ $subject->description }}"
                                    data-section="{{ $subject->section_name }}"
                                    data-teacher-id="{{ $subject->teacher_id }}">
                                    <i class="fa-solid fa-book" aria-hidden="true"></i>
                                    {{ $subject->subject_code }} - {{ $subject->subject_name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="note">Type to search for a subject.</div>
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Subject Title</label>
                        <input type="text" class="form-control p-1" id="title" name="title"
                            value="{{ old('title', $schedule->title) }}" class="@error('title') is-invalid @enderror"
                            required readonly>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control p-1" id="description" name="description"
                            rows="4">{{ old('description', $schedule->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="section_search" class="form-label">Section</label>
                        <div class="autocomplete-container">
                            <input type="text" class="form-control p-1" id="section_search"
                                placeholder="Type section name..." value="{{ old('section', $schedule->section) }}"
                                class="@error('section') is-invalid @enderror">
                            <input type="hidden" name="section" id="section"
                                value="{{ old('section', $schedule->section) }}"
                                class="@error('section') is-invalid @enderror" required>
                            <div class="autocomplete-suggestions" id="sectionSuggestions">
                                @foreach ($sections as $section)
                                <div class="suggestion-item" data-value="{{ $section->section_name }}">
                                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                                    {{ $section->section_name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="note">Type to search for an available section or select one.</div>
                        @error('section')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="days" class="form-label">Days</label>
                        <div class="day-checkboxes">
                            @php
                            $days = ['Monday' => 'M', 'Tuesday' => 'T', 'Wednesday' => 'W', 'Thursday' => 'Th', 'Friday'
                            => 'F', 'Saturday' => 'S'];
                            @endphp
                            @foreach ($days as $day => $abbr)
                            <div class="form-check">
                                <input class="form-check-input day-checkbox" type="checkbox" value="{{ $abbr }}"
                                    id="{{ $day }}"
                                    {{ in_array($abbr, str_split(old('days', $schedule->days))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $day }}">{{ $day }}</label>
                            </div>
                            @endforeach
                            <input type="hidden" name="days" id="days" value="{{ old('days', $schedule->days) }}"
                                class="@error('days') is-invalid @enderror" required>
                        </div>
                        <div class="note">Select one or more days (e.g., Monday + Tuesday + Wednesday = MTW).</div>
                        @error('days')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="term" class="form-label">Term</label>
                        <select class="form-control p-1" id="term" name="term"
                            class="@error('term') is-invalid @enderror" required>
                            <option value="">Select Term</option>
                            <option value="1st Term"
                                {{ old('term', $schedule->term) === '1st Term' ? 'selected' : '' }}>
                                1st Term</option>
                            <option value="2nd Term"
                                {{ old('term', $schedule->term) === '2nd Term' ? 'selected' : '' }}>
                                2nd Term</option>
                            <option value="3rd Term"
                                {{ old('term', $schedule->term) === '3rd Term' ? 'selected' : '' }}>
                                3rd Term</option>
                            <option value="4th Term"
                                {{ old('term', $schedule->term) === '4th Term' ? 'selected' : '' }}>
                                4th Term</option>
                        </select>
                        @error('term')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <div class="dropdown">
                            <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="timeDropdownBtn">
                                <i class="fa-solid fa-clock"></i> <span
                                    class="time-label">{{ old('time', $schedule->time) ?: 'Select a Time' }}</span>
                            </a>
                            <input type="hidden" name="time" id="time" value="{{ old('time', $schedule->time) }}"
                                class="@error('time') is-invalid @enderror" required>
                            <ul class="dropdown-menu" id="timeDropdown">
                                @php
                                $timeSlots = [
                                '08:00 AM - 09:00 AM',
                                '09:00 AM - 10:00 AM',
                                '11:00 AM - 12:00 PM',
                                '01:00 PM - 02:00 PM',
                                '02:00 PM - 03:00 PM',
                                '03:00 PM - 04:00 PM',
                                '04:00 PM - 05:00 PM',
                                ];
                                @endphp
                                @foreach ($timeSlots as $slot)
                                <li><a class="dropdown-item time-option" data-value="{{ $slot }}" href="#">
                                        <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                        {{ $slot }}
                                    </a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="note">Select the time slot for this schedule.</div>
                        @error('time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Room</label>
                        <input type="text" class="form-control p-1" id="room" name="room"
                            value="{{ old('room', $schedule->room) }}" class="@error('room') is-invalid @enderror"
                            required>
                        @error('room')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="teacher_search" class="form-label">Teacher</label>
                        <div class="autocomplete-container">
                            <input type="text" class="form-control p-1" id="teacher_search"
                                placeholder="Type teacher name..."
                                value="{{ old('teacher_search', $schedule->teacher ? $schedule->teacher->first_name . ' ' . $schedule->teacher->last_name : 'No Teacher') }}"
                                class="@error('teacher_id') is-invalid @enderror">
                            <input type="hidden" name="teacher_id" id="teacher_id"
                                value="{{ old('teacher_id', $schedule->teacher_id) }}"
                                class="@error('teacher_id') is-invalid @enderror">
                            <div class="autocomplete-suggestions" id="teacherSuggestions">
                                <div class="suggestion-item" data-value="" data-name="No Teacher">
                                    <i class="fa-solid fa-user" aria-hidden="true"></i>
                                    No Teacher
                                </div>
                                @foreach ($teachers as $teacher)
                                <div class="suggestion-item" data-value="{{ $teacher->id }}"
                                    data-name="{{ $teacher->first_name }} {{ $teacher->last_name }}">
                                    <i class="fa-solid fa-chalkboard-teacher" aria-hidden="true"></i>
                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- <div id="teacher-assigned-note" class="teacher-assigned"
                            style="display: {{ $schedule->teacher_id ? 'block' : 'none' }};">
                            This subject has an assigned teacher.
                        </div> -->
                        <div class="note">Type to search for a teacher or select 'No Teacher'.</div>
                        @error('teacher_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="strand_id" class="form-label">Strand</label>
                        <div class="dropdown">
                            <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="strandDropdownBtn">
                                <i class="fa-solid fa-person"></i> <span
                                    class="strand-label">{{ old('strand_id', $schedule->strand->strand_name) ?: 'Select a Strand' }}</span>
                            </a>
                            <input type="hidden" name="strand_id" id="strand_id"
                                value="{{ old('strand_id', $schedule->strand_id) }}"
                                class="@error('strand_id') is-invalid @enderror" required>
                            <ul class="dropdown-menu" id="strandDropdown">
                                @foreach ($strands as $strand)
                                <li><a class="dropdown-item strand-option" data-value="{{ $strand->id }}" href="#">
                                        @php
                                        $icon = 'fa-question';
                                        $strandNameLower = strtolower($strand->strand_name);
                                        switch (true) {
                                        case str_contains($strandNameLower, 'abm'):
                                        $icon = 'fa-briefcase';
                                        break;
                                        case str_contains($strandNameLower, 'stem'):
                                        $icon = 'fa-flask';
                                        break;
                                        case str_contains($strandNameLower, 'humss'):
                                        $icon = 'fa-book';
                                        break;
                                        case str_contains($strandNameLower, 'gas'):
                                        $icon = 'fa-pencil';
                                        break;
                                        }
                                        @endphp
                                        <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                                        {{ $strand->strand_name }}
                                    </a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="note">Select the strand for this schedule (e.g., STEM, ABM).</div>
                        @error('strand_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control p-1" id="status" name="status"
                            class="@error('status') is-invalid @enderror" required>
                            <option value="Active"
                                {{ old('status', $schedule->status) === 'Active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="Inactive"
                                {{ old('status', $schedule->status) === 'Inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary btn-sm p-1"><i class="fa-solid fa-floppy-disk"></i>
                        Update Schedule</button>
                    <a href="{{ route('schedule.index') }}" class="btn btn-outline-primary ms-2 btn-sm p-1">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const strandDropdownItems = document.querySelectorAll('.strand-option');
        const timeDropdownItems = document.querySelectorAll('.time-option');
        const strandHiddenInput = document.getElementById('strand_id');
        const timeHiddenInput = document.getElementById('time');
        const codeHiddenInput = document.getElementById('code');
        const sectionHiddenInput = document.getElementById('section');
        const teacherHiddenInput = document.getElementById('teacher_id');
        const strandDropdownBtn = document.getElementById('strandDropdownBtn');
        const timeDropdownBtn = document.getElementById('timeDropdownBtn');
        const strandLabel = strandDropdownBtn.querySelector('.strand-label');
        const timeLabel = timeDropdownBtn.querySelector('.time-label');
        const dayCheckboxes = document.querySelectorAll('.day-checkbox');
        const daysHiddenInput = document.getElementById('days');
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const teacherAssignedNote = document.getElementById('teacher-assigned-note');
        const subjectSearchInput = document.getElementById('subject_search');
        const subjectSuggestions = document.getElementById('subjectSuggestions');
        const subjectSuggestionItems = document.querySelectorAll('#subjectSuggestions .suggestion-item');
        const sectionSearchInput = document.getElementById('section_search');
        const sectionSuggestions = document.getElementById('sectionSuggestions');
        const sectionSuggestionItems = document.querySelectorAll('#sectionSuggestions .suggestion-item');
        const teacherSearchInput = document.getElementById('teacher_search');
        const teacherSuggestions = document.getElementById('teacherSuggestions');
        const teacherSuggestionItems = document.querySelectorAll('#teacherSuggestions .suggestion-item');
        const form = document.getElementById('scheduleForm');

        // Initialize dropdown labels and inputs if there's an old value
        if (strandHiddenInput.value) {
            const selectedStrand = document.querySelector(
                `.strand-option[data-value="${strandHiddenInput.value}"]`);
            if (selectedStrand) {
                strandLabel.textContent = selectedStrand.textContent.replace(/.*<\/i>/, '').trim();
            }
        }
        if (timeHiddenInput.value) {
            const selectedTime = document.querySelector(`.time-option[data-value="${timeHiddenInput.value}"]`);
            if (selectedTime) {
                timeLabel.textContent = selectedTime.textContent.replace(/.*<\/i>/, '').trim();
            }
        }
        if (codeHiddenInput.value) {
            const selectedSubject = document.querySelector(
                `#subjectSuggestions .suggestion-item[data-value="${codeHiddenInput.value}"]`);
            if (selectedSubject) {
                subjectSearchInput.value = selectedSubject.textContent.replace(/.*<\/i>/, '').trim();
            }
        }
        if (sectionHiddenInput.value) {
            const selectedSection = document.querySelector(
                `#sectionSuggestions .suggestion-item[data-value="${sectionHiddenInput.value}"]`);
            if (selectedSection) {
                sectionSearchInput.value = selectedSection.textContent.replace(/.*<\/i>/, '').trim();
            }
        }
        if (teacherHiddenInput.value) {
            const selectedTeacher = document.querySelector(
                `#teacherSuggestions .suggestion-item[data-value="${teacherHiddenInput.value}"]`);
            if (selectedTeacher) {
                teacherSearchInput.value = selectedTeacher.textContent.replace(/.*<\/i>/, '').trim();
            }
        }

        // Subject autocomplete
        subjectSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            subjectSuggestionItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) && query ? 'block' : 'none';
            });
            subjectSuggestions.classList.toggle('show', query.length > 0);
            codeHiddenInput.value = '';
            titleInput.value = '';
            descriptionInput.value = '';
            sectionHiddenInput.value = '';
            sectionSearchInput.value = '';
            teacherHiddenInput.value = '';
            teacherSearchInput.value = '';
            teacherAssignedNote.style.display = 'none';
        });

        subjectSearchInput.addEventListener('blur', function() {
            setTimeout(() => {
                subjectSuggestions.classList.remove('show');
            }, 200);
        });

        subjectSearchInput.addEventListener('focus', function() {
            if (this.value.trim()) {
                subjectSuggestions.classList.add('show');
            }
        });

        subjectSuggestionItems.forEach(item => {
            item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');
                const section = this.getAttribute('data-section');
                const teacherId = this.getAttribute('data-teacher-id');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();

                codeHiddenInput.value = value;
                subjectSearchInput.value = text;
                titleInput.value = title;
                descriptionInput.value = description || '';

                if (section) {
                    sectionHiddenInput.value = section;
                    sectionSearchInput.value = section;
                } else {
                    sectionHiddenInput.value = '';
                    sectionSearchInput.value = '';
                }

                if (teacherId) {
                    teacherHiddenInput.value = teacherId;
                    const selectedTeacher = document.querySelector(
                        `#teacherSuggestions .suggestion-item[data-value="${teacherId}"]`);
                    teacherSearchInput.value = selectedTeacher ?
                        selectedTeacher.textContent.replace(/.*<\/i>/, '').trim() :
                        '';
                    teacherAssignedNote.style.display = 'block';
                } else {
                    teacherHiddenInput.value = '';
                    teacherSearchInput.value = '';
                    teacherAssignedNote.style.display = 'none';
                }

                subjectSuggestions.classList.remove('show');
            });
        });

        // Section autocomplete
        sectionSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            sectionSuggestionItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) && query ? 'block' : 'none';
            });
            sectionSuggestions.classList.toggle('show', query.length > 0);
            sectionHiddenInput.value = '';
        });

        sectionSearchInput.addEventListener('blur', function() {
            setTimeout(() => {
                sectionSuggestions.classList.remove('show');
            }, 200);
        });

        sectionSearchInput.addEventListener('focus', function() {
            if (this.value.trim()) {
                sectionSuggestions.classList.add('show');
            }
        });

        sectionSuggestionItems.forEach(item => {
            item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                sectionHiddenInput.value = value;
                sectionSearchInput.value = value;
                sectionSuggestions.classList.remove('show');
            });
        });

        // Teacher autocomplete
        teacherSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            teacherSuggestionItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) && query ? 'block' : 'none';
            });
            teacherSuggestions.classList.toggle('show', query.length > 0);
            teacherHiddenInput.value = '';
        });

        teacherSearchInput.addEventListener('blur', function() {
            setTimeout(() => {
                teacherSuggestions.classList.remove('show');
            }, 200);
        });

        teacherSearchInput.addEventListener('focus', function() {
            if (this.value.trim()) {
                teacherSuggestions.classList.add('show');
            }
        });

        teacherSuggestionItems.forEach(item => {
            item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const name = this.getAttribute('data-name');
                teacherHiddenInput.value = value;
                teacherSearchInput.value = name;
                teacherSuggestions.classList.remove('show');
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

        // Handle time selection
        timeDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();
                timeHiddenInput.value = value;
                timeLabel.textContent = text;
            });
        });

        // Handle day checkbox selection
        function updateDays() {
            const selectedDays = Array.from(dayCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            daysHiddenInput.value = selectedDays.join('');
            daysHiddenInput.dispatchEvent(new Event('change')); // Ensure form recognizes update
        }

        dayCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateDays);
        });

        // Initialize days if old value exists
        if (daysHiddenInput.value) {
            const oldDays = daysHiddenInput.value.split('');
            dayCheckboxes.forEach(checkbox => {
                checkbox.checked = oldDays.includes(checkbox.value);
            });
            updateDays();
        }

        // Prevent form submission if no days are selected
        form.addEventListener('submit', function(e) {
            if (!daysHiddenInput.value) {
                e.preventDefault();
                alert('Please select at least one day for the schedule.');
                daysHiddenInput.classList.add('is-invalid');
                const invalidFeedback = daysHiddenInput.parentElement.querySelector('.invalid-feedback');
                if (invalidFeedback) {
                    invalidFeedback.textContent = 'The days field is required.';
                    invalidFeedback.style.display = 'block';
                }
            }
        });
    });
</script>
@endsection