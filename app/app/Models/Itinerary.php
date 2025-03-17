<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
      'title',
      'category',
      'duration',
      'image',
      'user_id',
  ];

  // Relation avec l'utilisateur
  public function user()
  {
      return $this->belongsTo(User::class);
  }

  // Relation avec les destinations
  public function destinations()
  {
      return $this->hasMany(Destination::class);
  }
}
