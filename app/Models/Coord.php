<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Circuit;

class Coord extends Model
{
    protected $table = "coords";
    protected $primaryKey = 'id';
    protected $fillable = [
        'accuracy',
        'latitude',
        'longitude',
        'speed',
        'start_end',
        'timestamp',
        'id_circuit',
    ];

    // public function circuit(): BelongsTo {
    //     return $this->belongsTo(Circuit::class, 'id_user', 'id');
    // }

    // public function lap(): BelongsTo {
    //     return $this->belongsTo(Lap::class, 'id_user', 'id');
    // }
}
