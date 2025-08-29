<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GuruController extends Controller
{
    public function index() {
        // take data from database
        if (Session::get('is_superadmin')) {
            $studentCount = DB::table('students')->count();
        } else {
            $studentCount = DB::table('students')
                ->whereIn('section_id', Session::get('section_ids'))
                ->count();
        }
        $attendanceCount = DB::table('attendances')->where('date', now()->toDateString())->count();
        $data = [
            'studentCount' => $studentCount,
            'attendanceCount' => $attendanceCount,
        ];

        return view('pages.guru.dashboard', $data);
    }
}
