<?php

namespace App\Imports;

use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToCollection
{
    protected $section_id;
    protected $unit;

    public function __construct($section_id) {
        $this->section_id = $section_id;
        $section = Section::find($section_id);
        $this->unit = 'NO_UNIT';
        if ($section) {
            $this->unit = $section->name;
        }
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            // SKIP HEADER
            if ($index == 0) {
                continue;
            }

            // VALIDASI : KALO NAMA GAADA DATA KE SKIP DAN JENIS KELAMIN CUMA L ATAU P
            if ($row[0] == null || !in_array(strtolower($row[2]), ['l','p'])) {
                continue;
            }

            // VALIDASI : KALO ADA IDENTIFIER YANG SAMA KE SKIP
            $existingStudentWithSameIdentifier = DB::table('students')
                ->where('identifier', $row[4])->first();
            if ($existingStudentWithSameIdentifier) {
                continue;
            }

            $row[2] = match(strtolower($row[2])) {
                'l'  => 'Laki-laki',
                'p'  => 'Perempuan',
                default => null
            };

            if ($row[4] == null) {
                $row[4] = uniqid()."_".strtoupper($this->unit)."_".str_replace(' ','_',$row[0]);
            }

            $birthDate = now();
            if (is_numeric($row[1])) {
                try {
                    $birthDate = Date::excelToDateTimeObject($row[1]);
                } catch (\Exception $e) {}
            }

            $newData = [
                'name'          => $row[0],
                'section_id'    => $this->section_id,
                'birth'         => $birthDate,
                'gender'        => $row[2],
                'parent_number' => normalizePhoneNumber($row[3]),
                'identifier'    => $row[4],
            ];

            Student::create($newData);
        }
    }
}

function normalizePhoneNumber($number) {
    // Hilangkan spasi, strip, titik
    $number = preg_replace('/[\s\.\-]/', '', $number);

    if (strpos($number, '+62') === 0) {
        // Sudah format +62...
        return $number;
    } elseif (strpos($number, '62') === 0) {
        // Sudah format 62..., tambahkan +
        return '+'.$number;
    } elseif (strpos($number, '0') === 0) {
        // Format 08..., ganti 0 dengan +62
        return '+62'.substr($number, 1);
    } elseif (strpos($number, '8') === 0) {
        // Format 8..., tambahkan +62
        return '+62'.$number;
    } else {
        // Jika tidak sesuai aturan, kembalikan apa adanya
        return $number;
    }
}
