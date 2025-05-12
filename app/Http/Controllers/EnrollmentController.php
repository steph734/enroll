<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function show($page)
    {
        $allowedPages = [
            'dashboard',
            'students',
            'teachers',
            'subject-section',
            'section',
            'payment',
            'schedule',
            'reports',
            'accounts',
            'enrollment_form',
            'teacher_form',
            'edit',
            'studentedit',
            'subjectform',
            'subjectedit',
        ];

        if (!in_array($page, $allowedPages)) {
            abort(404, 'Page not found');
        }

        // Pass the current page as activePage to the view
        $activePage = $page;

        return view("enrollment.{$page}", compact('page', 'activePage'));
    }
}
