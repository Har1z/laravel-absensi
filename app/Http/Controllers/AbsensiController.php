<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('pages.guru.absen-kehadiran');
    }

    public function absen(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
        ]);

        // get student data
        $student = Student::where('identifier', $request->identifier)->first();

        if (!$student) {
            return response()->json(['console' => 'Siswa tidak ditemukan'], 404);
        }

        $today = Carbon::today()->toDateString();

        // check if student has present today
        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

            // if hasn't present → do check-in
            if (!$attendance) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'check_in_time' => now(),
                    'unit' => $student->unit,
                    'status' => 'present',
                ]);

                // get count of present, late, absent, total
                $counts = $this->getStatistics($student->id);

                return response()->json(
                    [
                        'log' => 'masuk',
                        'console' => 'Berhasil check-in siswa : ' . $student->name,
                        'nama' => $student->name,
                        'profile_pict' => asset('storage/' . $student->profile_pict),
                        'unit' => $student->unit,
                        'waktu' => now()->format('H:i:s'),
                        'count_tepat_waktu' => $counts->count_tepat_waktu,
                        'count_terlambat' => $counts->count_terlambat,
                        'count_alpa' => $counts->count_alpa,
                        'count_total' => $counts->count_total,
                    ]);
        }

        // if already present → check if already check-out
        if (is_null($attendance->check_out_time)) {
            $attendance->update([
                'check_out_time' => now(),
            ]);

            // get count of present, late, absent, total
            $counts = $this->getStatistics($student->id);

            return response()->json(
                [
                    'log' => 'pulang',
                    'console' => 'Berhasil check-out siswa : ' . $student->name,
                    'nama' => $student->name,
                    'profile_pict' => asset('storage/' . $student->profile_pict),
                    'unit' => $student->unit,
                    'waktu' => now()->format('H:i:s'),
                    'count_tepat_waktu' => $counts->count_tepat_waktu,
                    'count_terlambat' => $counts->count_terlambat,
                    'count_alpa' => $counts->count_alpa,
                    'count_total' => $counts->count_total,
            ]);
        }

        // if already present and check-out → cannot check-out again
        return response()->json(['console' => 'Sudah check-out hari ini'], 403);
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

        // dd($logs);
        return response()->json($logs);
    }
}
