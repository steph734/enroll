<?php


namespace App\Http\Controllers;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    
    public function create()
    {
        return view('enrollment.teacher_form'); 
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'profile_picture' => 'nullable|image|max:2048',
            'prc_copy' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'transcript' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file uploads
        $paths = [];
        if ($request->hasFile('profile_picture')) {
            $paths['profile_picture'] = $request->file('profile_picture')->store('public/teachers/profiles');
        }
        $paths['prc_copy'] = $request->file('prc_copy')->store('public/teachers/documents');
        $paths['resume'] = $request->file('resume')->store('public/teachers/documents');
        $paths['transcript'] = $request->file('transcript')->store('public/teachers/documents');

        // Create teacher record
        $teacher = Teacher::create(array_merge(
            $request->all(),
            $paths
        ));

        return redirect()->route('teachers.create')->with('success', 'Teacher registered successfully');
    }
}
