<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    use HasFactory;

    protected $table = 't_attendance';

    protected $fillable = [
        'attend_event_id',
        'attend_student_id',
        'attend_student_name',
        'attend_checked_in_at',
        'attend_checked_out_at'
    ];
}
