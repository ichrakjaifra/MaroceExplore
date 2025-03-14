<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\DestinationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/itineraires', function(){
//   return 'itineraires';
// });

// Route::post('/itineraires', function(){

// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);

    // Gestion des itinéraires
    Route::prefix('itineraires')->group(function () {
      // Créer un nouvel itinéraire
      Route::post('/add', [ItineraryController::class, 'store']);

      // Modifier un itinéraire
      Route::put('/{id}', [ItineraryController::class, 'update']);

      // Ajouter un itinéraire à la "liste à visiter"
      Route::post('/{id}/wishlist', [ItineraryController::class, 'addToWishlist']);

      // Rechercher et filtrer les itinéraires
      Route::get('/search', [ItineraryController::class, 'search']);

      // Récupérer tous les itinéraires avec leurs destinations
      Route::get('/', [ItineraryController::class, 'index']);

      // Récupérer les itinéraires les plus populaires
      Route::get('/popular', [ItineraryController::class, 'popular']);

      // Statistiques : Nombre total d'itinéraires par catégorie
      Route::get('/stats', [ItineraryController::class, 'stats']);
  });

  // Gestion des destinations
  Route::prefix('destinations')->group(function () {
    // Ajouter une destination à un itinéraire
    Route::post('/add/{id}', [DestinationController::class, 'store']);

    // Modifier une destination
    Route::put('/update/{id}', [DestinationController::class, 'update']);

    // Supprimer une destination
    Route::delete('/delete/{id}', [DestinationController::class, 'destroy']);
});
});
