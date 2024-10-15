<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    protected $table = 't_feedbacks';

    protected $fillable = [
        'event_id',
        'student_id',
        'directory',
        'file_names',
    ];

    protected $casts = [
        'file_names' => 'array', // Cast the JSON column to an array
    ];
}
