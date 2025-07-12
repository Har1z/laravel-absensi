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
        $data = [
            'studentCount' => $studentCount,
        ];

        return view('pages.guru.dashboard', $data);
    }
}
