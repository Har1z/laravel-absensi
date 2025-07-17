{{-- <style>
    table, td, th {
        border: 1px solid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
</style> --}}
<table style="table-collapse: collapse;">
    @php
        use Carbon\Carbon;

        // Total days in the month from
        $totalDays = Carbon::create($year, $month)->daysInMonth;
    @endphp
    <thead>
        <tr>
            <th style="border: 1px solid black ;width: 300px; text-align: center;" rowspan="2">Nama Siswa</th>
            <th style="border: 1px solid black ;height: 20px; width: 200px; text-align: center;" colspan="{{ $totalDays }}">Tanggal</th>
            <th style="border: 1px solid black ;height: 30px; width: 200px; text-align: center;" colspan="3">Keterangan</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= $totalDays; $i++)
                @php
                    $date = Carbon::create($year, $month, $i);
                    $dayName = $date->translatedFormat('l'); // 'Sabtu', 'Minggu', etc.
                    $isWeekend = $dayName === 'Sabtu' || $dayName === 'Minggu';
                @endphp
                <th style="border: 1px solid black;height: 25px; width: 25px; text-align: center; {{ $isWeekend ? 'color: red;' : '' }}">
                    {{ $i }}
                </th>
            @endfor
            <th style="border: 1px solid black;height: 25px; width: 50px; text-align: center;">Hadir</th>
            <th style="border: 1px solid black;height: 25px; width: 50px; text-align: center;">Izin</th>
            <th style="border: 1px solid black;height: 25px; width: 50px; text-align: center;">Alpa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td style="border: 1px solid black;height: 30px; text-align: center; font-weight: bold">{{ $student->name }}</td>

            @php
                $attendances = collect($student->attendances);
                $stats = ['present' => 0, 'excused' => 0, 'absent' => 0];
            @endphp

            @for ($i = 1; $i <= $totalDays; $i++)
                @php
                    $date = Carbon::create($year, $month, $i);
                    $dayName = $date->translatedFormat('l'); // 'Sabtu', 'Minggu', etc.
                    $isWeekend = $dayName === 'Sabtu' || $dayName === 'Minggu';
                    $tanggal = \Carbon\Carbon::createFromDate($year, $month, $i)->format('Y-m-d');
                    $attendance = $attendances->firstWhere('date', $tanggal);
                    $symbol = '';

                    if ($attendance) {
                        switch ($attendance->status) {
                            case 'present': $symbol = 'H'; $stats['present']++; break;
                            case 'late':    $symbol = 'H'; $stats['present']++; break;
                            case 'excused': $symbol = 'I'; $stats['excused']++; break;
                        }
                    } else if (!$isWeekend) {
                        $symbol = 'A'; $stats['absent']++;
                    }
                @endphp
                <td style="border: 1px solid black;text-align: center;">{{ $symbol }}</td>
            @endfor

            <td style="border: 1px solid black;text-align: center;">{{ $stats['present'] }}</td>
            <td style="border: 1px solid black;text-align: center;">{{ $stats['excused'] }}</td>
            <td style="border: 1px solid black;text-align: center;">{{ $stats['absent'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
