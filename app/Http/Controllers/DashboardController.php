<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total students
        $totalStudents = Student::count();

        // Pending students (students with 'pending' status)
        $pendingStudents = Student::where('status', 'pending')->count();

        // Active students (students with 'active' or 'enrolled' status)
        $activeStudents = Student::where('status', 'active')->count();

        // Recent students
        $recentStudents = Student::select('id', 'first_name', 'last_name', 'grade_level', 'strand_id', 'status')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Data for pie charts (student distribution by strand)
        $hummsCount = Student::where('strand_id', 'HUMMS')->count();
        $stemCount = Student::where('strand_id', 'STEM')->count();
        $abmCount = Student::where('strand_id', 'ABM')->count();
        $totalStrandStudents = $hummsCount + $stemCount + $abmCount;
        $otherCount = $totalStudents - $totalStrandStudents;

        // Chart data
        $chartData = [
            'humms' => [
                'strand_id' => $hummsCount,
                'others' => $totalStudents - $hummsCount,
            ],
            'stem' => [
                'strand_id' => $stemCount,
                'others' => $totalStudents - $stemCount,
            ],
            'abm' => [
                'strand_id' => $abmCount,
                'others' => $totalStudents - $abmCount,
            ],
        ];

        return view('enrollment.dashboard', compact(
            'totalStudents',
            'pendingStudents',
            'activeStudents',
            'recentStudents',
            'chartData'
        ));
    }
}
