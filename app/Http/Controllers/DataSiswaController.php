<?php

namespace App\Http\Controllers;

use App\Exports\GetTemplateExport;
use App\Imports\StudentImport;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::get('is_superadmin')) {
            $students = Student::with(['section'])->get();
            $sections = Section::all();
        } else {
            $students = Student::whereIn('section_id', Session::get('section_ids'))->get();
            $sections = Section::whereIn('id', Session::get('section_ids'))->get();
        }

        // dd($students);
        $data = [
            'students' => $students,
            'sections' => $sections,
        ];
        return view('pages.guru.data-siswa', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Session::get('is_superadmin')) {
            $sections = Section::get()->toArray();
        } else {
            $sections = Section::whereIn('id', Session::get('section_ids'))->get()->toArray();
        }
        $data = [
            'sections' => $sections
        ];
        return view('pages.guru.data-siswa-form', $data);
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
            'parent_number' => 'required|numeric',
            'other_parent_number' => 'nullable|numeric',
            'section_id' => 'required',
            'identifier' => 'nullable|unique:students,identifier',
            'file' => 'nullable|image|max:150',
        ]);

        $profilePict = null;

        if($validatedData['parent_number'] && $validatedData['parent_number'][0] == 0) {
            $validatedData['parent_number'] = substr($validatedData['parent_number'], 1);
        }
        if($validatedData['other_parent_number'] && $validatedData['other_parent_number'][0] == 0) {
            $validatedData['other_parent_number'] = substr($validatedData['other_parent_number'], 1);
        }

        $validatedData['parent_number'] = "+62".$validatedData['parent_number'];
        $validatedData['other_parent_number'] = "+62".$validatedData['other_parent_number'];

        if ($request->hasFile('file')) {
            $file           = $request->file('file');
            $fileOriginName = $file->getClientOriginalName();
            $profilePict    = str_replace('public/','',$file->storeAs('uploads/profile_pict', uniqid()."_".$fileOriginName)); // "uploads/profile_pict" ?
        }

        $validatedData['profile_pict'] = $profilePict;

        // check if the identifier is empty (if empty, generate it)
        if (empty($validatedData['identifier'])) {
            $unit   = Section::find($request->section_id)->name; // TK, SD, SMP, SMK
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
        $sections = Section::all();
        $student = Student::FindOrFail($id);
        $studentPict = Storage::disk('public')->exists($student->profile_pict ?? 'NONE')
                ? asset('storage/'.$student->profile_pict)
                : null; // Ganti Null jadi default image kalo kosong

        $data = [
            'sections'    => $sections,
            'student'     => $student,
            'studentPict' => $studentPict,
        ];
        return view('pages.guru.data-siswa-form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'birth' => 'required',
            'gender' => 'required',
            'parent_number' => 'required|numeric',
            'other_parent_number' => 'nullable|numeric',
            'section_id' => 'required',
            'file' => 'nullable|max:150|image',
            'identifier' => 'required|unique:students,identifier,'.$id,
        ]);

        $student                   = Student::findOrFail($id);
        $currentStudentProfilePict = null;
        $studentOldPictFileName    = null;
        $pict                      = $student->profile_pict;

        $student->profile_pict && $currentStudentProfilePict = explode('/', $student->profile_pict);
        if ($currentStudentProfilePict) {
            $studentOldPictFileName = end($currentStudentProfilePict);
        }

        if ($request->hasFile('file')) {
            $newFile                = $request->file('file');
            $newFileOriginName      = $newFile->getClientOriginalName();
            $isNewFileSameAsOldFile = $studentOldPictFileName == $newFileOriginName;

            if ($student->profile_pict && !$isNewFileSameAsOldFile && Storage::disk('public')->exists($student->profile_pict)) {
                Storage::disk('public')->delete($student->profile_pict);
                $pict = str_replace('public/','',$newFile->storeAs('uploads/profile_pict', uniqid()."_".$newFileOriginName));
            } else if (!$student->profile_pict) {
                $pict = str_replace('public/','',$newFile->storeAs('uploads/profile_pict', uniqid()."_".$newFileOriginName));
            }
        } else {
            $pict = null;
            if ($student->profile_pict && Storage::disk('public')->exists($student->profile_pict)) {
                Storage::disk('public')->delete($student->profile_pict);
            }
        }

        $validatedData['parent_number'] = str_replace('+62','',$validatedData['parent_number']);
        if($validatedData['parent_number'] && $validatedData['parent_number'][0] == 0) {
            $validatedData['parent_number'] = substr($validatedData['parent_number'], 1);
        }

        if ($validatedData['other_parent_number']) {
            $validatedData['other_parent_number'] = str_replace('+62','',$validatedData['other_parent_number']);
            if($validatedData['other_parent_number'] && $validatedData['other_parent_number'][0] == 0) {
                $validatedData['other_parent_number'] = substr($validatedData['other_parent_number'], 1);
            }

            $validatedData['other_parent_number'] = "+62".$validatedData['other_parent_number'];
        }

        $validatedData['parent_number'] = "+62".$validatedData['parent_number'];
        $validatedData['profile_pict']  = $pict;

        $student->update($validatedData);

        // return dd($validatedData);
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
        if ($studentPict && Storage::disk('public')->exists($studentPict)) {
            Storage::delete($studentPict);
        }
        return redirect()->route('data-siswa.index');
    }
}
