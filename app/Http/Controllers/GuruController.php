<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index() {
        // take data from database
        $studentCount = DB::table('students')->count();
        $attendanceCount = DB::table('attendances')->where('date', now()->toDateString())->count();
        $data = [
            'studentCount' => $studentCount,
            'attendanceCount' => $attendanceCount,
        ];

        return view('pages.guru.dashboard', $data);
    }
}
