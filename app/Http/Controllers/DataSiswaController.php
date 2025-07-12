<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'name' => 'required',
            'birth' => 'required',
            'gender' => 'required',
            'parent_number' => 'required',
            'unit' => 'required',
        ]);

        $data = $request->all();

        // check if the identifier is empty (if empty, generate it)
        if (empty($data['identifier'])) {
            $unit = strtoupper($request->unit); // TK, SD, SMP, SMK
            $name = preg_replace('/\s+/', '', $request->name); // Hilangkan spasi
            $random = rand(100, 999);

            $data['identifier'] = "{$unit}-{$name}-{$random}";
        }

        Student::create($data);
        return redirect()->route('data-siswa.index');
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
        Student::FindOrFail($id)->delete();
        return redirect()->route('data-siswa.index');
    }
}
