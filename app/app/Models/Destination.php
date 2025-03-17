<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
      'name',
      'accommodation',
      'places_to_visit',
      'activities',
      'dishes_to_try',
      'itinerary_id',
  ];

  // Cast attributes to native types
  protected $casts = [
      'places_to_visit' => 'array', // Automatically convert to/from JSON
      'activities' => 'array',      // Automatically convert to/from JSON
      'dishes_to_try' => 'array',   // Automatically convert to/from JSON
  ];

  // Relation avec l'itinéraire
  public function itinerary()
  {
      return $this->belongsTo(Itinerary::class, 'itinerary_id');
  }
}
