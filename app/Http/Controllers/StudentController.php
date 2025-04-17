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

    // Store the newly created student data in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|max:2048',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:students,email',
            'school' => 'required|string|max:255',
            'grade_level' => 'required|string|max:255',
            'year_graduated' => 'required|string|max:4',
            'parent_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:20',
            'parent_email' => 'required|email|max:255',
        ]);

        // Handle file uploads (profile picture)
        $data = $validated;
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('students/profiles', 'public');
        }

        // Create the student record in the database
        Student::create($data);

        // Redirect to the students index page after successful creation
        return redirect()->route('student.index')->with('success', 'Student registered successfully');
    }

    // Display the list of all students
    public function index()
    {
        // Fetch all students from the database
        $students = Student::all();

        // Return the students view with the fetched student data
        return view('enrollment.students', compact('students'));
    }

    // Show the form for editing a student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('enrollment.student_edit', compact('students'));
    }

    // Update the specified student in the database
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Validate the incoming request data
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|max:2048',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'school' => 'required|string|max:255',
            'grade_level' => 'required|string|max:255',
            'year_graduated' => 'required|string|max:4',
            'parent_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:20',
            'parent_email' => 'required|email|max:255',
        ]);

        // Handle file uploads (profile picture)
        $data = $validated;
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($student->profile_picture) {
                Storage::delete($student->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('students/profiles', 'public');
        }

        // Update the student record
        $student->update($data);

        // Redirect to the students index page
        return redirect()->route('student.index')->with('success', 'Student updated successfully');
    }

    // Delete a student from the database
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete profile picture if it exists
        if ($student->profile_picture) {
            Storage::delete($student->profile_picture);
        }

        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student deleted successfully');
    }
}