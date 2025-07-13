<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function attendanceTime() {
        $settings = Setting::select('id', 'unit', 'present_time')->get();

        $data = [
            'settings' => $settings,
        ];
        return view('pages.guru.setting-jam', $data);
    }

    public function updateAttendanceTime(Request $request) {
        $request->validate([
            'present_time' => 'required',
        ]);

        $setting = Setting::findOrFail($request->id);
        $setting->present_time = $request->present_time;
        $setting->save();
        return redirect()->route('setting.attendance-time');
    }

    public function attendanceMessage() {
        $settings = Setting::select('id', 'unit', 'in_message', 'out_message')->get();

        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->unit] = $setting;
        }

        return view('pages.guru.setting-pesan', compact('data'));
    }

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
