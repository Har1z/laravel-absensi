<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AttendanceDataExport implements FromView
{
    protected $students;
    protected $month;
    protected $year;

    public function __construct($students, $month, $year)
    {
        $this->students = $students;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $data = [
            'students' => $this->students,
            'month' => $this->month,
            'year' => $this->year,
        ];

        return view('pages.guru.template-data-absensi', $data);
    }
}
