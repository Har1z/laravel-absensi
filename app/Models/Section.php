<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id', 'id');
    }

    public function user_sections()
    {
        return $this->hasMany(UserSection::class, 'section_id', 'id');
    }
}
