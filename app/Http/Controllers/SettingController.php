<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // show kelola jam masuk tab
    public function attendanceTime() {
        $settings = Setting::select('id', 'section_id', 'present_time', 'out_time')->with('section')->get();

        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->section->name] = $setting;
        }

        return view('pages.guru.setting-jam', compact('data'));
    }

    // update jam masuk
    public function updateAttendanceTime(Request $request) {
        $request->validate([
            'id' => 'required',
            'present_time' => 'required',
            'out_time' => 'required',
        ]);

        $setting = Setting::findOrFail($request->id);
        $setting->present_time = $request->present_time;
        $setting->save();
        return redirect()->route('setting.attendance-time');
    }

    // show kelola pesan tab
    public function attendanceMessage() {
        $settings = Setting::with('section')->get();

        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->section->name] = $setting;
        }

        return view('pages.guru.setting-pesan', compact('data'));
    }

    // update pesan
    public function updateAttendanceMessage(Request $request) {
        $request->validate([
            'id' => 'required',
            'in_message' => 'required',
            'out_message' => 'required',
        ]);

        DB::table('settings')
        ->where('id', $request->id)
        ->update([
            'in_message' => $request->in_message,
            'out_message' => $request->out_message,
            'updated_at' => now(),
        ]);

        return redirect(route('setting.attendance-message'));
    }
}
