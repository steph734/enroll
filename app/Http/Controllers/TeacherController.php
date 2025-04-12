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


    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('enrollment.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        // Validation rules
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'age' => 'required|integer|min:18',
            'specialization' => 'required|string|max:255',
            'employment_status' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
            'prc_copy' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file uploads
        $paths = [];
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($teacher->profile_picture) {
                Storage::delete($teacher->profile_picture);
            }
            $paths['profile_picture'] = $request->file('profile_picture')->store('public/teachers/profiles');
        }
        if ($request->hasFile('prc_copy')) {
            // Delete old PRC copy if it exists
            if ($teacher->prc_copy) {
                Storage::delete($teacher->prc_copy);
            }
            $paths['prc_copy'] = $request->file('prc_copy')->store('public/teachers/documents');
        }
        if ($request->hasFile('resume')) {
            // Delete old resume if it exists
            if ($teacher->resume) {
                Storage::delete($teacher->resume);
            }
            $paths['resume'] = $request->file('resume')->store('public/teachers/documents');
        }
        if ($request->hasFile('transcript')) {
            // Delete old transcript if it exists
            if ($teacher->transcript) {
                Storage::delete($teacher->transcript);
            }
            $paths['transcript'] = $request->file('transcript')->store('public/teachers/documents');
        }

        // Update teacher record
        $teacher->update(array_merge(
            $request->only(['first_name', 'last_name', 'email', 'age', 'specialization', 'employment_status', 'subjects']),
            $paths
        ));

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully');
    }
}





