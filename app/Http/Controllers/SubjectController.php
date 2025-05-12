<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $strand = $request->query('strand');
        $sort = $request->query('sort');
        $search = $request->query('search');

        $strands = \App\Models\Strands::pluck('strand_name', 'id')->all();

        $query = Subject::with(['strand', 'track']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('subject_code', 'like', "%{$search}%")
                    ->orWhere('subject_name', 'like', "%{$search}%");
            });
        }

        if ($strand) {
            $fullStrandName = collect($strands)->filter(function ($name) use ($strand) {
                return str_contains(strtolower($name), strtolower($strand));
            })->first();

            if ($fullStrandName) {
                $query->whereHas('strand', function ($q) use ($fullStrandName) {
                    $q->where('strand_name', $fullStrandName);
                });
            }
        }

        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'a-z':
                $query->orderBy('subject_name', 'asc');
                break;
            case 'z-a':
                $query->orderBy('subject_name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $subjects = $query->get();

        $activePage = 'subject-section'; // Set the active page for this route

        return view('enrollment.subject-section', compact('subjects', 'strand', 'sort', 'strands', 'search', 'activePage'));
    }

    public function create()
    {
        $tracks = \App\Models\Tracks::all();
        $strands = \App\Models\Strands::all();
        $activePage = 'subjectform'; // Set the active page for this route
        return view('enrollment.subjectform', compact('tracks', 'strands', 'activePage'));
    }

    public function edit($id)
    {
        $subject = \App\Models\Subject::findOrFail($id);
        $tracks = \App\Models\Tracks::all();
        $strands = \App\Models\Strands::all();
        $activePage = 'subjectedit'; // Set the active page for this route
        return view('enrollment.subjectedit', compact('subject', 'tracks', 'strands', 'activePage'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject_code' => 'required|string|max:10|unique:subjects,subject_code',
            'subject_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'strand_id' => 'required|exists:strands,id',
            'track_id' => 'required|exists:tracks,id',
        ]);
        Subject::create($validatedData);

        return redirect()->route('subject.index')->with('success', 'Subject created successfully.');
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validatedData = $request->validate([
            'subject_code' => 'required|string|max:10|unique:subjects,subject_code,' . $subject->id,
            'subject_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'strand_id' => 'required|exists:strands,id',
            'track_id' => 'required|exists:tracks,id',
        ]);

        $subject->update($validatedData);

        return redirect()->route('subject.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.index')->with('success', 'Subject deleted successfully.');
    }
}
