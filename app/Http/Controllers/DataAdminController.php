<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\User;
use App\Models\UserSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DataAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userHash = [];
        $users    = User::where('is_superadmin', 0)->get()->toArray();

        foreach ($users as $user) {
            if (!array_key_exists($user['id'], $userHash)) {
                $userHash[$user['id']] = [];
            }

            $userHash[$user['id']] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'sections' => []
            ];

            $userSections = UserSection::where('user_id', $user['id'])->get()->toArray();
            foreach ($userSections as $us) {
                $section = Section::find($us['section_id']);
                if ($section && !in_array($section->name, $userHash[$user['id']]['sections'])) {
                    $userHash[$user['id']]['sections'][] = $section->name;
                }
            }
        }

        $data = [
            'userHash' => $userHash,
        ];
        return view('pages.data_admin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::get()->toArray();
        $data = [
            'sections' => $sections
        ];
        return view('pages.data_admin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'section' => 'nullable|array'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        DB::beginTransaction();
        $user = User::create($validatedData);

        foreach ($validatedData['section'] as $sectionId) {
            UserSection::firstOrCreate([
                'user_id' => $user->id,
                'section_id' => $sectionId
            ]);
        }
        DB::commit();

        return redirect(route('data-admin.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sections = Section::get()->toArray();
        $user = User::find($id);
        if (!$user) {
            return redirect(route('data-admin.index'));
        }

        $userSections = UserSection::where('user_id', $user->id)->pluck('section_id')->toArray();

        $data = [
            'user' => $user,
            'sections' => $sections,
            'userSections' => $userSections,
        ];

        return view('pages.data_admin.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'new_password' => 'nullable|min:8',
            'section' => 'nullable|array'
        ]);

        $user = User::find($id);

        $validatedData['new_password'] = Hash::make($validatedData['new_password']);

        DB::beginTransaction();
        if (array_key_exists('new_password', $validatedData)) {
            $validatedData['password'] = $validatedData['new_password'];
        }
        $user->update($validatedData);
        UserSection::where('user_id', $user->id)->delete();

        foreach ($validatedData['section'] as $sectionId) {
            UserSection::firstOrCreate([
                'user_id' => $user->id,
                'section_id' => $sectionId
            ]);
        }
        DB::commit();

        return redirect(route('data-admin.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $message = 'Tidak ada user yang dihapus !';
        if ($user) {
            $name = $user->name;
            $user->delete();
            $message = "Berhasil menghapus $name";
        }

        return redirect(route('data-admin.index'));
    }
}
