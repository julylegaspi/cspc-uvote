<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $course = $request->course;
        $section = $request->section;
        
        if ($course > 0 and $section === 0)
        {
            $users = User::where('course_id', $course)
                    ->orderBy('name', 'asc')        
                    ->get();
        } 

        if ($course > 0 and $section > 0)
        {
            $users = User::where('course_id', $course)
                    ->where('section_id', $section)
                    ->orderBy('name', 'asc')
                    ->get();
        }

        if ($course == 0 and $section == 0)
        {
            $users = User::orderBy('name', 'asc')->get();
        }

        $pdf = Pdf::loadView('users-pdf', [
            'users' => $users
        ]);

        return $pdf->stream('users.pdf');
    }
}
