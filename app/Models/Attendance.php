<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    public function student() {
        return $this->belongsTo(Student::class);
    }

    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'date',
        'check_in_time',
        'check_out_time',
        'unit',
        'status',
        'note',
        'created_at', // auto input
        'updated_at',
    ];
}
