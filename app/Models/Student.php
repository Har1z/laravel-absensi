<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
    public function getFormattedBirthAttribute() {
        return Carbon::parse($this->birth)->format('d F Y');
    }

    protected $table = 'students';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'section_id',
        'birth',
        'gender',
        'parent_number',
        'other_parent_number',
        'email',
        'identifier',
        'profile_pict',
        'created_at', // auto input
        'updated_at', // auto input
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
