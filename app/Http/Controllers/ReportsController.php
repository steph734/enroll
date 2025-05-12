<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;

class ReportsController extends Controller
{
    public function index()
    {
        return view('enrollment.reports');
    }

    public function generate($type)
    {
        if (!in_array($type, ['enrollment', 'student'])) {
            abort(404, 'Invalid report type');
        }

        if ($type === 'enrollment') {
            // Fetch students with related data for enrollment report
            $data = Student::with(['section', 'strand', 'track'])->get();
            $reportTitle = 'Enrollment Report';
            $view = 'enrollment.reportenrollment';
        } else {
            // Fetch students for student report
            $data = Student::with(['section'])->get();
            $reportTitle = 'Student Report';
            $view = 'enrollment.reportstudent';
        }

        $pdfData = [
            'title' => $reportTitle,
            'data' => $data,
            'date' => now()->format('Y-m-d'),
        ];

        $pdf = Pdf::loadView($view, $pdfData);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($type . '_report_' . now()->format('Ymd') . '.pdf');
    }
}
