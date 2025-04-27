<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Display the student enrollment form
    public function create()
    {
         
        return view('enrollment.enrollment_form');
    }
    public function index()
    {
        $student = Student::all();
        return view('students.index', compact('students'));
    }

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
            'relationship' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
            'previous_school' => 'required|string|max:255',
            'grade_completed' => 'required|string|max:255',
            'school_year_completed' => 'required|string|max:255',
            'gpa' => 'nullable|string|max:10',
            'transcript' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'track' => 'required|string|max:255',
            'strand' => 'nullable|string|max:255',
            'grade_level' => 'required|string|max:255',
            'class_schedule' => 'required|string|max:255',
            'additional_notes' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'special_accommodations' => 'nullable|string',
            'studentid' => 'required|numeric|digits:6',
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
            'track' => $request->track,
            'strand' => $request->strand,
            'grade_level' => $request->grade_level,
            'class_schedule' => $request->class_schedule,
            'additional_notes' => $request->additional_notes,
            'medical_info' => $request->medical_info,
            'special_accommodations' => $request->special_accommodations,
            'studentid' => $request->studentid,
        ]);

        return redirect()->route('students.index')->with('success', 'Student enrolled successfully!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('enrollment.studentedit', compact('student'));
    }

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
            'relationship' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
            'previous_school' => 'required|string|max:255',
            'grade_completed' => 'required|string|max:255',
            'school_year_completed' => 'required|string|max:255',
            'gpa' => 'nullable|string|max:10',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'track' => 'required|string|max:255',
            'strand' => 'nullable|string|max:255',
            'grade_level' => 'required|string|max:255',
            'class_schedule' => 'required|string|max:255',
            'additional_notes' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'special_accommodations' => 'nullable|string',
            'studentid' => 'required|numeric|digits:6|unique:students,studentid,' . $id,
            'status' => 'required|in:ongoing,graduated,dropped',
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
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}

?>