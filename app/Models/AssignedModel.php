<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedModel extends Model
{
    use HasFactory;

    protected $table = 't_assign';

    protected $fillable = [
        'student_id',
        'student_name',
        'course_id',
        'assign_type',
    ];
}
