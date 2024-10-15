<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InchargeModel extends Model
{
    use HasFactory;

    protected $table = 't_incharge_logs';

    protected $fillable = [
        'logs_sid',
        'logs_status',
        'logs_event_id'
    ];
}
