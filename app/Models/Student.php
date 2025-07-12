<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    public function getFormattedBirthAttribute() {
        return Carbon::parse($this->birth)->format('d F Y');
    }

    protected $table = 'students';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'birth',
        'gender',
        'parent_number',
        'other_parent_number',
        'unit',
        'email',
        'identifier',
        'profile_pict',
        'created_at', // auto input
        'updated_at', // auto input
    ];
}
