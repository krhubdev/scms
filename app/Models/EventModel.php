<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = 't_events';
    protected $fillable = [
        'event_name',
        'event_description',
        'event_start_date',
        'event_end_date',
        'event_location',
        'event_course',
        'created_by',
    ];
}
