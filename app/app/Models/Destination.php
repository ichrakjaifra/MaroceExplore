<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'accommodation', 'places_to_visit', 'activities', 'dishes_to_try', 'itinerary_id'];

    public function itinerary()
    {
        return $this->belongsTo(Itineraires::class,"destinations.itinerary_id");
    }
}
