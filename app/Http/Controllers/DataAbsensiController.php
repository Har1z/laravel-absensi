<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceDataExport;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
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

        $students = Attendance::with('student')->where('date', date('Y-m-d'))->get();

        $data = [
            'students' => $students,
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
            'unit' => 'required|string',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
        ]);

        $unit = $request->unit;
        $month = $request->month;
        $year = $request->year;
        $students = Student::where('unit', $unit)
            ->with(['attendances' => function ($query) use ($month, $year) {
                $query->whereMonth('date', $month)
                      ->whereYear('date', $year);
        }])->get();

        // dd($data);
        return Excel::download(new AttendanceDataExport($students, $month, $year), 'rekap_absensi_'.$unit.'.xlsx');
    }
}
