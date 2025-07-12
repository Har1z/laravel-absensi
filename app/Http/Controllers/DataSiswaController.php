<?php

namespace App\Http\Controllers;

use App\Exports\GetTemplateExport;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        // dd($students);
        $data = [
            'students' => $students
        ];
        return view('pages.guru.data-siswa', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.guru.data-siswa-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'birth' => 'required',
            'gender' => 'required',
            'parent_number' => 'required',
            'unit' => 'required',
            'identifier' => 'nullable|unique:students,identifier',
            'file' => 'nullable|image|mimes:png,jpeg,jpg|max:150',
        ]);

        $profilePict = null;

        if ($request->hasFile('file')) {
            $file           = $request->file('file');
            $fileOriginName = $file->getClientOriginalName();
            $profilePict    = str_replace('public/','',$file->storeAs('public/uploads/profile_pict', $fileOriginName));
        }

        $validatedData['profile_pict'] = $profilePict;

        // check if the identifier is empty (if empty, generate it)
        if (empty($data['identifier'])) {
            $unit   = strtoupper($request->unit); // TK, SD, SMP, SMK
            $name   = preg_replace('/\s+/', '_', $request->name); // replace spasi jadi underscore
            $random = uniqid();

            $validatedData['identifier'] = "{$random}_{$unit}_{$name}";
        }

        Student::create($validatedData);
        return redirect()->route('data-siswa.index');
    }

    public function ImportStudenData(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new StudentImport($request->unit), $request->file('file'));
        return back()->with('success', 'Data berhasil diimpor!');
    }

    public function GetTemplateData()
    {
        return Excel::download(new GetTemplateExport, 'template-import-siswa.xlsx');
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
        $student = Student::FindOrFail($id);
        return view('pages.guru.data-siswa-form', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'birth' => 'required',
            'gender' => 'required',
            'parent_number' => 'required',
            'unit' => 'required',
        ]);

        Student::FindOrFail($id)->update($request->all());
        return redirect()->route('data-siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $studentPict = $student->profile_pict;
        $student->delete();
        if ($studentPict && Storage::disk('pubilc')->exists($studentPict)) {
            Storage::delete($studentPict);
        }
        return redirect()->route('data-siswa.index');
    }
}
