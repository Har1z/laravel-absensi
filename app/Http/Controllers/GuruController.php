<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Attendance;

class GuruController extends Controller
{
    public function index() {
        // take data from database
        if (Session::get('is_superadmin')) {
            $studentCount = DB::table('students')->count();
            $attendanceCount = Attendance::with('student')
                ->where('date', now()->toDateString())
                ->count();
        } else {
            $studentCount = DB::table('students')
                ->whereIn('section_id', Session::get('section_ids'))
                ->count();
            $attendanceCount = Attendance::whereDate('date', now())
                ->whereHas('student', fn($student) => $student->whereIn('section_id', Session::get('section_ids')))
                ->count();
        }
        $data = [
            'studentCount' => $studentCount,
            'attendanceCount' => $attendanceCount,
        ];

        return view('pages.guru.dashboard', $data);
    }
}
