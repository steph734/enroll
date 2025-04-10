<?php


namespace App\Http\Controllers;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{

    public function index() {
        $teachers = Teacher::all(); // Fetch all teachers from the database
        return view('enrollment.teachers', compact('teachers'));
    }
    
    public function create()
    {
        return view('enrollment.teacher_form'); 
    }
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('enrollment.teachers', compact('teachers'));
    }

    public function update(Request $request, Teacher $teacher)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:teachers,email,' . $teacher->id,
        'age' => 'required|integer|min:18|max:100',
        'specialization' => 'required|in:STEM,ABM,HUMMMS',
        'employment_status' => 'required|in:Full-time,Part-time,Contractual',
    ]);

    $teacher->update($validated);
    
    return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully');
}
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')
                        ->with('success', 'Teacher deleted successfully');
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
