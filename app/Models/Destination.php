<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = ['city_name', 'country', 'description', 'image'];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
