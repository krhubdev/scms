<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model
{
    use HasFactory;

    protected $table = 't_courses';

    protected $fillable = [
        'id',
        'course_name',
        'course_major',
    ];
}
