<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'in_message',
        'out_message',
        'present_time',
        'updated_at',
    ];
}
