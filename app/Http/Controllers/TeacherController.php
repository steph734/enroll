<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    // Display the teacher form
    public function create()
    {
        return view('enrollment.teacher_form');
    }

    // Display the teachers list
    public function index()
    {
        return redirect()->route('enrollment.show', 'teachers');
    }

    // Store a new teacher
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'age' => 'required|integer|min:1',
            'specialization' => 'required|in:Academic,TVL,Sports,Arts',
            'employment_status' => 'required|in:Full-time,Part-time,Contractual',
            'prc_copy' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'transcript' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'degree' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'year_graduated' => 'required|string|max:4',
            'prc_license' => 'required|string|max:255',
            'license_validity' => 'required|date',
            'let_date' => 'required|date',
            'previous_school' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'teaching_schedule' => 'required|in:Morning,Afternoon,Evening',
            'certifications' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'accommodations' => 'nullable|string',
            'date_hired' => 'required|date',
            'employee_id' => 'required|string|max:255|unique:teachers,employee_id',
        ]);

        // Handle file uploads
        $profilePicturePath = $request->file('profile_picture')
            ? $request->file('profile_picture')->store('teachers/profiles', 'public')
            : null;
        $prcCopyPath = $request->file('prc_copy')
            ? $request->file('prc_copy')->store('teachers/documents', 'public')
            : null;
        $resumePath = $request->file('resume')
            ? $request->file('resume')->store('teachers/documents', 'public')
            : null;
        $transcriptPath = $request->file('transcript')
            ? $request->file('transcript')->store('teachers/documents', 'public')
            : null;

        // Create teacher record
        Teacher::create([
            'profile_picture' => $profilePicturePath,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'age' => $request->age,
            'specialization' => $request->specialization,
            'employment_status' => $request->employment_status,
            'prc_copy' => $prcCopyPath,
            'resume' => $resumePath,
            'transcript' => $transcriptPath,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'degree' => $request->degree,
            'major' => $request->major,
            'university' => $request->university,
            'year_graduated' => $request->year_graduated,
            'prc_license' => $request->prc_license,
            'license_validity' => $request->license_validity,
            'let_date' => $request->let_date,
            'previous_school' => $request->previous_school,
            'position' => $request->position,
            'years_experience' => $request->years_experience,
            'teaching_schedule' => $request->teaching_schedule,
            'certifications' => $request->certifications,
            'medical_info' => $request->medical_info,
            'accommodations' => $request->accommodations,
            'date_hired' => $request->date_hired,
            'employee_id' => $request->employee_id,
        ]);

        return redirect()->route('enrollment.show', 'teachers')->with('success', 'Teacher registered successfully!');
    }

    // Edit teacher form
    public function edit(Request $request, $id, $formtype = 'view')
    {
        $teacher = Teacher::findOrFail($id);

        if ($formtype === 'view') {
            return view('enrollment.teacheredit', compact('teacher', 'formtype'));
        } elseif ($formtype === 'teacheredit') {
            return view('enrollment.teacheredit', compact('teacher', 'formtype'));
        }

        return redirect()->route('teachers.index')->with('error', 'Invalid form type.');
    }

    // Update teacher
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'age' => 'required|integer|min:1',
            'specialization' => 'required|in:Academic,TVL,Sports,Arts',
            'employment_status' => 'required|in:Full-time,Part-time,Contractual',
            'prc_copy' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'degree' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'year_graduated' => 'required|string|max:4',
            'prc_license' => 'required|string|max:255',
            'license_validity' => 'required|date',
            'let_date' => 'required|date',
            'previous_school' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'teaching_schedule' => 'required|in:Morning,Afternoon,Evening',
            'certifications' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'accommodations' => 'nullable|string',
            'date_hired' => 'required|date',
            'employee_id' => 'required|string|max:255|unique:teachers,employee_id,' . $id,
        ]);

        $teacher = Teacher::findOrFail($id);

        // Handle file uploads
        if ($request->hasFile('profile_picture')) {
            if ($teacher->profile_picture) {
                Storage::disk('public')->delete($teacher->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('teachers/profiles', 'public');
        }
        if ($request->hasFile('prc_copy')) {
            if ($teacher->prc_copy) {
                Storage::disk('public')->delete($teacher->prc_copy);
            }
            $validated['prc_copy'] = $request->file('prc_copy')->store('teachers/documents', 'public');
        }
        if ($request->hasFile('resume')) {
            if ($teacher->resume) {
                Storage::disk('public')->delete($teacher->resume);
            }
            $validated['resume'] = $request->file('resume')->store('teachers/documents', 'public');
        }
        if ($request->hasFile('transcript')) {
            if ($teacher->transcript) {
                Storage::disk('public')->delete($teacher->transcript);
            }
            $validated['transcript'] = $request->file('transcript')->store('teachers/documents', 'public');
        }

        $teacher->update($validated);

        return redirect()->route('teachers.edit', ['id' => $id, 'formtype' => 'view'])
            ->with('success', 'Teacher updated successfully.');
    }

    // Delete teacher
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        foreach (['profile_picture', 'prc_copy', 'resume', 'transcript'] as $file) {
            if ($teacher->$file) {
                Storage::disk('public')->delete($teacher->$file);
            }
        }
        $teacher->delete();

        return redirect()->route('enrollmment.show', 'teachers')->with('success', 'Teacher deleted successfully.');
    }

    // Filter teachers
    public function filter(Request $request)
    {
        $query = Teacher::query();

        // Input validation
        $search = $request->input('search', '');
        $specialization = $request->input('specialization', 'all');
        $status = $request->input('status', 'all');
        $sort = $request->input('sort', 'none');

        // Search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Specialization filter
        if ($specialization !== 'all') {
            $query->where('specialization', $specialization);
        }

        // Status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Sort filter
        switch ($sort) {
            case 'name-asc':
                $query->orderBy('first_name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('first_name', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc'); // Default sorting
                break;
        }

        // Pagination
        $perPage = 10;
        $page = $request->input('page', 1);
        $teachers = $query->paginate($perPage, ['*'], 'page', $page);

        // Return JSON response
        return response()->json([
            'teachers' => $teachers->items(),
            'current_page' => $teachers->currentPage(),
            'last_page' => $teachers->lastPage(),
            'total' => $teachers->total(),
        ]);
    }

    // Search for autocomplete suggestions
    public function search(Request $request)
    {
        $search = $request->search;
        $teachers = Teacher::where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->take(5)
            ->get(['id', 'first_name', 'last_name']);

        return response()->json($teachers);
    }
}
