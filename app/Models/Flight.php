<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = ['departure_city', 'destination_id', 'airline', 'flight_duration'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
