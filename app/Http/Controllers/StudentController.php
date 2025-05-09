<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tracks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Display the student enrollment form
    public function create()
    {
        $tracks = Tracks::all();
        return view('enrollment.enrollment_form', compact('tracks'));
    }

    // Display the students list
    public function index()
    {
        return route('enrollment.show', 'students');
    }
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }
    // Store a new student
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'contact_number' => 'required|string|max:20',
            'secondary_contact' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'guardian_first_name' => 'required|string|max:255',
            'guardian_middle_name' => 'nullable|string|max:255',
            'guardian_last_name' => 'required|string|max:255',
            'relationship' => 'required|string|in:Mother,Father,Guardian,Other',
            'guardian_contact' => 'required|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
            'previous_school' => 'required|string|max:255',
            'grade_completed' => 'required|string|in:Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9,Grade 10',
            'school_year_completed' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'gpa' => 'nullable|string|max:10',
            'transcript' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'track_id' => 'required|exists:tracks,id',
            'strand_id' => 'required|exists:strands,id',
            'grade_level' => 'required|string|in:Grade 11,Grade 12',
            'class_schedule' => 'required|string|in:Morning,Afternoon,Evening',
            'additional_notes' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'special_accommodations' => 'nullable|string',
            'studentid' => 'required|numeric|digits:6|unique:students,studentid',
            'payment_date' => 'required|date',
            'downpayment' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:Cash,Credit Card,Bank Transfer,Online Payment',
            'balance' => 'required|numeric|min:0',
            'receiptnumber' => 'required|string|size:6|unique:students,receiptnumber',
        ]);

        // Handle file uploads
        $profilePicturePath = $request->file('profile_picture')
            ? $request->file('profile_picture')->store('profile_pictures', 'public')
            : null;
        $transcriptPath = $request->file('transcript')
            ? $request->file('transcript')->store('transcripts', 'public')
            : null;

        // Create student record
        Student::create([
            'profile_picture' => $profilePicturePath,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'age' => $request->age,
            'nationality' => $request->nationality,
            'home_address' => $request->home_address,
            'zip_code' => $request->zip_code,
            'contact_number' => $request->contact_number,
            'secondary_contact' => $request->secondary_contact,
            'email' => $request->email,
            'guardian_first_name' => $request->guardian_first_name,
            'guardian_middle_name' => $request->guardian_middle_name,
            'guardian_last_name' => $request->guardian_last_name,
            'relationship' => $request->relationship,
            'guardian_contact' => $request->guardian_contact,
            'guardian_email' => $request->guardian_email,
            'previous_school' => $request->previous_school,
            'grade_completed' => $request->grade_completed,
            'school_year_completed' => $request->school_year_completed,
            'gpa' => $request->gpa,
            'transcript' => $transcriptPath,
            'track_id' => $request->track_id,
            'strand_id' => $request->strand_id,
            'grade_level' => $request->grade_level,
            'class_schedule' => $request->class_schedule,
            'additional_notes' => $request->additional_notes,
            'medical_info' => $request->medical_info,
            'special_accommodations' => $request->special_accommodations,
            'studentid' => $request->studentid,
            'payment_date' => $request->payment_date,
            'downpayment' => $request->downpayment,
            'payment_method' => $request->payment_method,
            'balance' => $request->balance,
            'receiptnumber' => $request->receiptnumber,
        ]);

        return redirect()->route('students.index')->with('success', 'Student enrolled successfully!');
    }

    // Generate unique receipt number
    private function generateReceiptNumber()
    {
        do {
            $receiptNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Student::where('receiptnumber', $receiptNumber)->exists());

        return $receiptNumber;
    }

    // Edit student form
    public function edit(Request $request,  $id)
    {
        $student = Student::findOrFail($id);
        $tracks = Tracks::all();
        return view('enrollment.studentedit', compact('student', 'tracks'));
    }

    // Update student
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'contact_number' => 'required|string|max:20',
            'secondary_contact' => 'nullable|string|max:20',
            'email' => 'required|email|unique:students,email,' . $id,
            'guardian_first_name' => 'required|string|max:255',
            'guardian_middle_name' => 'nullable|string|max:255',
            'guardian_last_name' => 'required|string|max:255',
            'relationship' => 'required|string|in:Mother,Father,Guardian,Other',
            'guardian_contact' => 'required|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
            'previous_school' => 'required|string|max:255',
            'grade_completed' => 'required|string|in:Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9,Grade 10',
            'school_year_completed' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'gpa' => 'nullable|string|max:10',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'track_id' => 'required|exists:tracks,id',
            'strand_id' => 'required|exists:strands,id',
            'grade_level' => 'required|string|in:Grade 11,Grade 12',
            'class_schedule' => 'required|string|in:Morning,Afternoon,Evening',
            'additional_notes' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'special_accommodations' => 'nullable|string',
            'studentid' => 'required|numeric|digits:6|unique:students,studentid,' . $id,
            'status' => 'required|in:ongoing,graduated,dropped',
            'payment_date' => 'required|date',
            'downpayment' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:Cash,Credit Card,Bank Transfer,Online Payment',
            'balance' => 'required|numeric|min:0',
            'receiptnumber' => 'required|string|size:6|unique:students,receiptnumber,' . $id,
        ]);

        $student = Student::findOrFail($id);

        // Handle file uploads
        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
        if ($request->hasFile('transcript')) {
            if ($student->transcript) {
                Storage::disk('public')->delete($student->transcript);
            }
            $validated['transcript'] = $request->file('transcript')->store('transcripts', 'public');
        }

        $student->update($validated);
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    // Delete student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        if ($student->profile_picture) {
            Storage::disk('public')->delete($student->profile_picture);
        }
        if ($student->transcript) {
            Storage::disk('public')->delete($student->transcript);
        }
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    // Filter students
    public function filter(Request $request)
    {
        $query = Student::with(['track', 'strand']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Strand filter
        if ($request->has('strand') && $request->strand !== 'all') {
            $query->whereHas('strand', function ($q) use ($request) {
                $q->where('strand_name', $request->strand);
            });
        }

        // Grade filter
        if ($request->has('grade') && $request->grade !== 'all') {
            $query->where('grade_level', $request->grade);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name-asc':
                    $query->orderBy('first_name', 'asc');
                    break;
                case 'name-desc':
                    $query->orderBy('first_name', 'desc');
                    break;
                case 'grade-asc':
                    $query->orderBy('grade_level', 'asc');
                    break;
                case 'grade-desc':
                    $query->orderBy('grade_level', 'desc');
                    break;
            }
        }

        $students = $query->get();

        return response()->json(['students' => $students]);
    }

    // Search for autocomplete suggestions
    public function search(Request $request)
    {
        $search = $request->search;
        $students = Student::where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->take(5)
            ->get(['id', 'first_name', 'last_name']);

        return response()->json($students);
    }
}
