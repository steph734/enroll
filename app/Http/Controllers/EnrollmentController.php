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
            'sections',
            'payment',
            'class_schedule',
            'reports',
            'accounts',
            'enrollment_form',
            'teacher_form'
        ];

        if (!in_array($page, $allowedPages)) {
            abort(404, 'Page not found');
        }

        // Use dot notation for views in subdirectories
        return view("enrollment.{$page}", compact('page'));
    }
}
