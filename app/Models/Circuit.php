<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Coord;

class Circuit extends Model
{
    protected $table = 'circuits';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'length'
    ];

    public function coords(): HasMany {
        return $this->hasMany(Coord::class, 'id_circuit', 'id');
    }
}
