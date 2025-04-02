<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lap extends Model
{
    protected $table = "laps";
    protected $primaryKey = 'id';
    protected $fillable = [
        'isValid',
        'time',
        'distance_traveled',
        'avg_speed',
        'top_speed',
        'avg_accuracy',
        'coords_count',
        'id_user',
        'id_circuit',
    ];
}
