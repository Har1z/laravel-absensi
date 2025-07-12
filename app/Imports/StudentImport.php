<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToCollection
{
    protected $unit;

    public function __construct($unit) {
        $this->unit = $unit;
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
                'unit'          => $this->unit,
                'birth'         => $birthDate,
                'gender'        => $row[2],
                'parent_number' => "+62".$row[3],
                'identifier'    => $row[4],
            ];

            Student::create($newData);
        }
    }
}
