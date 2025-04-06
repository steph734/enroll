<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Student;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function create()
    {
        return view('enrollment.enrollment_form'); 
    }
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'home_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'profile_picture' => 'nullable|image|max:2048',
            'transcript' => 'required|file|mimes:pdf,doc,docx|max:2048',
            // Add other validation rules as needed
        ]);

        // Handle file uploads
        $data = $request->all();

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        if ($request->hasFile('transcript')) {
            $data['transcript'] = $request->file('transcript')->store('transcripts', 'public');
        }

        // Create student record
        Student::create($data);

        return redirect()->route('student.index');
    }

    public function index()
    {
      
        return view('enrollment.students');
    }
}