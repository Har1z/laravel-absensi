<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use DB;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index() {
        return view('pages.guru.absen-kehadiran');
    }

    public function indexPulang() {
        return view('pages.guru.absen-pulang');
    }

    public function absen(Request $request) {
        $request->validate([
            'identifier' => 'required|string',
        ]);

        // get student data
        $student = Student::where('identifier', $request->identifier)->first();

        // if the student is not found
        if (!$student) {
            return response()->json(['console' => 'Siswa tidak ditemukan'], 404);
        }

        $setting = Setting::where('section_id', $student->section_id)->first();
        $now = now();
        $status = $now->greaterThan($setting->present_time) ? 'late' : 'present'; // to check if the student are late or not
        $unit = Section::find($student->section_id)->name;

        // check if student has present today
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        // if hasn't present and the time is past out_time → do check-out
        if (!$attendance && $now->greaterThan($setting->out_time)) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'check_out_time' => $now,
                'unit' => $unit,
                'status' => 'late', // kind of punishment for forgetting to check-in
            ]);

            // send message to parent
            $message = str_replace('{nama}', $student->name, $setting->out_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }

            return response()->json(
                [
                    'log' => 'pulang',
                    'console' => 'Berhasil check-in siswa : ' . $student->name,
                    'nama' => $student->name,
                    'profile_pict' => asset('storage/' . $student->profile_pict),
                    'unit' => $unit,
                    'waktu' => $now->format('H:i:s'),
                ]);
        }

        // if hasn't present → do check-in
        if (!$attendance) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'check_in_time' => $now,
                'unit' => $unit,
                'status' => $status, //if $setting->present_time < now() == late
            ]);

            // send message to parent
            $message = str_replace('{nama}', $student->name, $setting->in_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }

            return response()->json(
                [
                    'log' => 'masuk',
                    'console' => 'Berhasil check-in siswa : ' . $student->name,
                    'nama' => $student->name,
                    'profile_pict' => asset('storage/' . $student->profile_pict),
                    'unit' => $student->unit,
                    'waktu' => $now->format('H:i:s'),
                ]);
        }

        // if already present → check if already check-out
        if (is_null($attendance->check_out_time)) {
            $attendance->update([
                'check_out_time' => $now,
            ]);

            $message = str_replace('{nama}', $student->name, $setting->out_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }

            return response()->json(
                [
                    'log' => 'pulang',
                    'console' => 'Berhasil check-out siswa : ' . $student->name,
                    'nama' => $student->name,
                    'profile_pict' => asset('storage/' . $student->profile_pict),
                    'unit' => $unit,
                    'waktu' => $now->format('H:i:s'),
            ]);
        }

        // if already present and check-out → cannot check-out again
        return response()->json(['console' => 'Sudah check-out hari ini'], 403);
    }

    public function absenPulang(Request $request) {
        $request->validate([
            'identifier' => 'required',
        ]);

        // get student data
        $student = Student::where('identifier', $request->identifier)->first();
        response()->json(['console' => $student], 200);

        // if the student is not found
        if (!$student) {
            return response()->json(
                [
                    'msg' => 'Data tidak ditemukan',
                    'color' => 'danger',
                    'console' => 'Siswa dengan identifier tersebut tidak ditemukan',
                ], 404);
        }

        $setting = Setting::where('section_id', $student->section_id)->first();
        $now = now();
        $status = $now->greaterThan($setting->present_time) ? 'late' : 'present'; // to check if the student are late or not
        $unit = Section::find($student->section_id)->name;

        // check if student has present today
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'check_out_time' => $now,
                'unit' => $unit,
                'status' => $status, //if $setting->present_time < now() == late
            ]);

            // send message to parent
            $message = str_replace('{nama}', $student->name, $setting->in_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }

            return response()->json(
                [
                    'msg' => 'Berhasil Absen Pulang',
                    'color' => 'warning',
                    'console' => 'Berhasil Absen Pulang : ' . $student->name,
                    'nama' => $student->name,
                    'unit' => $unit,
                    'pulang' => $now->format('H:i:s'),
                ]);
        }

        // if already present → check if already check-out
        if (is_null($attendance->check_out_time)) {
            $attendance->update([
                'check_out_time' => $now,
            ]);

            $message = str_replace('{nama}', $student->name, $setting->out_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }

            return response()->json(
                [
                    'msg' => 'Berhasil Absen Pulang',
                    'color' => 'warning',
                    'console' => 'Berhasil Absen Pulang : ' . $student->name,
                    'nama' => $student->name,
                    'unit' => $unit,
                    'masuk' => $attendance->check_in_time,
                    'pulang' => $now->format('H:i:s'),
                ], 200);
        }


        // if already present and check-out → cannot check-out again
        return response()->json([
            'msg' => 'Sudah Absen Pulang',
            'color' => 'danger',
            'console' => 'Sudah Absen Pulang Hari Ini',
            'nama' => $student->name,
            'unit' => $unit,
            'masuk' => $attendance->check_in_time,
            'pulang' => $attendance->check_out_time,
        ], 200);
    }


    public function absenPulangbaru(Request $request) {
        $request->validate([
            'identifier' => 'required',
        ]);

        // get student data
        $student = Student::where('identifier', $request->identifier)->first();

        // if the student is not found
        if (!$student) {
            return response()->json(['console' => 'Siswa tidak ditemukan'], );
        }

        $setting = Setting::where('section_id', $student->section_id)->first();
        $now = now();
        $status = $now->greaterThan($setting->present_time) ? 'late' : 'present'; // to check if the student are late or not
        $unit = Section::find($student->section_id)->name;

        // check if student has present today
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'check_out_time' => $now,
                'unit' => $unit,
                'status' => $status, //if $setting->present_time < now() == late
            ]);

            // send message to parent
            $message = str_replace('{nama}', $student->name, $setting->in_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }

            return response()->json(
                [
                    'msg' => 'Berhasil Absen Pulang',
                    'color' => 'warning',
                    'console' => 'Berhasil Absen Pulang : ' . $student->name,
                    'nama' => $student->name,
                    'unit' => $unit,
                    'pulang' => $now->format('H:i:s'),
                ], 200);
        }

        // if already present → check if already check-out
        if (is_null($attendance->check_out_time)) {
            // $attendance->update([
            //     'check_out_time' => $now,
            // ]);

            $message = str_replace('{nama}', $student->name, $setting->out_message);
            $this->sendMessage($message, $student->parent_number);
            if (!empty($student->other_parent_number)) {
                $this->sendMessage($message, $student->other_parent_number);
            }
            // return response()->json(['console' => "bisa!" . $student->name . $unit . $status ], 200);

            return response()->json(
                [
                    'msg' => 'Berhasil Absen Pulang',
                    'color' => 'warning',
                    'console' => 'Berhasil Absen Pulang : ' . $student->name,
                    'nama' => $student->name,
                    'unit' => $unit,
                    'masuk' => $attendance->check_in_time,
                    'pulang' => $now->format('H:i:s'),
                ], 200);
        }

    }

    public function absenIzin(Request $request) {
        $request->validate([
            'identifier' => 'required|string',
            'note' => 'required|string',
        ]);

        // get student data
        $student = Student::where('identifier', $request->identifier)->first();

        // if the student is not found
        if (!$student) {
            return response()->json(['console' => 'Siswa tidak ditemukan'], 404);
        }

        $setting = Setting::where('unit', $student->unit)->first();
        $now = now();

        // check if student has present today
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        // if hasn't present → do check-in
        if (!$attendance) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'unit' => $student->unit,
                'status' => 'excused', //if $setting->present_time < now() == late
            ]);

            return redirect()->back()->with('success', 'Berhasil mengajukan izin');
        }

        // if already present and check-out → cannot check-out again
        return redirect()->back()->with('error', 'Sudah mengajukan izin hari ini');

    }

    private function sendMessage(string $message, $phoneNumber) {
        $dataSending = Array();
        $dataSending["api_key"] = env('WATZAP_API_KEY');
        $dataSending["number_key"] = env('WATZAP_NUMBER_KEY');
        $dataSending["phone_no"] = $phoneNumber;
        $dataSending["message"] = $message;
        // $dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($dataSending),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;
    }

    // how to make this func automatically run afterschool... uh, I don't know.
    public function markAbsentStudents() {
        $today = Carbon::today()->toDateString();

        $students = Student::all();

        foreach ($students as $student) {
            $alreadyPresent = Attendance::where('student_id', $student->id)
                ->whereDate('date', $today)
                ->exists();

            if (!$alreadyPresent) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'unit' => $student->unit,
                    'status' => 'absent',
                ]);
            }
        }
    }

    private function getStatistics($studentId)  {
        // get count of present, late, absent, total
        $counts = Attendance::selectRaw("
            SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as count_tepat_waktu,
            SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as count_terlambat,
            SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as count_alpa,
            COUNT(*) as count_total
        ")->where('student_id', $studentId)->first();

        return $counts;
    }

    public function getAttendanceLog(){
        $today = Carbon::today()->toDateString();
        $logHash = [];

        $checkInQuery = DB::table('attendances')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->select('students.name', 'attendances.student_id', DB::raw("'masuk' as type"), 'check_in_time as time')
            ->where('attendances.date', $today);

        $logs = DB::table('attendances')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->select('students.name', 'attendances.student_id', DB::raw("'pulang' as type"), 'check_out_time as time')
            ->where('attendances.date', $today)
            ->unionAll($checkInQuery)
            ->orderBy('time', 'asc')
            ->get();


            foreach ($logs as $data) {
                $name = $data->name;
                $student_id = $data->student_id;
                $type = $data->type;
                $time = $data->time;

                if (!empty($time)) {
                    $logHash[] = $data;
                }
            };
            // dd($logs, $logHash);
            return response()->json($logHash);
    }
}
