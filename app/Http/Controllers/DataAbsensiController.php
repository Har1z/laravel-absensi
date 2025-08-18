<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceDataExport;
use App\Models\Section;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DataAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $checkRequest = $request->validate([
            'date' => 'nullable|date',
        ]);

        if (Session::get('is_superadmin')) {
            $sections = Section::get()->toArray();;
        } else {
            $sections = Section::whereIn('id', Session::get('section_ids'))->get()->toArray();
        }

        $students = Attendance::with('student')
            ->where('date', date('Y-m-d'));

        if (!Session::get('is_superadmin')) {
            $students = $students->whereHas('student', fn($q) => $q->whereIn('section_id', Session::get('section_ids')));
        }

        $students = $students->get();

        $data = [
            'students' => $students,
            'sections' => $sections,
        ];
        return view('pages.guru.data-absensi', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Attendance::FindOrFail($id)->delete();
        return redirect()->route('data-absensi.index');
    }

    public function getReport(Request $request) {
        $validateData = request()->validate([
            'unit' => 'required',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
        ]);

        $unit = $request->unit;
        $month = $request->month;
        $year = $request->year;

        $section = Section::find($unit);
        $students = Student::where('section_id', $unit)
            ->with(['attendances' => function ($query) use ($month, $year) {
                $query->whereMonth('date', $month)
                      ->whereYear('date', $year);
        }])->get();

        // dd($data);
        return Excel::download(new AttendanceDataExport($students, $month, $year), 'rekap_absensi_'.$section->name.'.xlsx');
    }
}
