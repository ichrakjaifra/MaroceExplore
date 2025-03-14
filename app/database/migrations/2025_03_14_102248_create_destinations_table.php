<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**  Illuminate\Database\QueryException 

     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
          $table->id();
          $table->foreignId('itinerary_id')->constrained('itineraires')->onDelete('cascade');
          $table->string('name');
          $table->string('accommodation');
          $table->string('places_to_visit')->nullable();
          $table->string('activities')->nullable();
          $table->string('dishes_to_try')->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
