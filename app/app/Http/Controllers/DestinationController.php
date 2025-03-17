<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Itinerary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DestinationController extends Controller
{
    /**
     * Ajouter une destination à un itinéraire
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id',
            'name' => 'required|string|max:255',
            'accommodation' => 'required|string|max:255',
            'places_to_visit' => 'nullable|array',
            'activities' => 'nullable|array',
            'dishes_to_try' => 'nullable|array',
        ]);

        // Vérifier que l'itinéraire appartient à l'utilisateur connecté
        $itinerary = Itinerary::where('user_id', Auth::id())
            ->findOrFail($request->itinerary_id);

        // Créer la destination
        $destination = Destination::create([
            'itinerary_id' => $itinerary->id,
            'name' => $request->name,
            'accommodation' => $request->accommodation,
            'places_to_visit' => $request->places_to_visit ?? [],
            'activities' => $request->activities ?? [],
            'dishes_to_try' => $request->dishes_to_try ?? [],
        ]);

        return response()->json([
            'message' => 'Destination added successfully',
            'destination' => $destination,
        ], 201);
    }

    /**
     * Modifier une destination existante
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'accommodation' => 'sometimes|string|max:255',
            'places_to_visit' => 'nullable|array',
            'activities' => 'nullable|array',
            'dishes_to_try' => 'nullable|array',
        ]);

        // Trouver la destination
        $destination = Destination::findOrFail($id);

        // Vérifier que l'itinéraire associé appartient à l'utilisateur connecté
        $itinerary = Itinerary::where('user_id', Auth::id())
            ->findOrFail($destination->itinerary_id);

        // Mettre à jour la destination
        $destination->update($request->only([
            'name', 'accommodation', 'places_to_visit', 'activities', 'dishes_to_try'
        ]));

        return response()->json([
            'message' => 'Destination updated successfully',
            'destination' => $destination,
        ], 200);
    }

    /**
     * Supprimer une destination
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Trouver la destination
        $destination = Destination::findOrFail($id);

        // Vérifier que l'itinéraire associé appartient à l'utilisateur connecté
        $itinerary = Itinerary::where('user_id', Auth::id())
            ->findOrFail($destination->itinerary_id);

        // Supprimer la destination
        $destination->delete();

        return response()->json([
            'message' => 'Destination deleted successfully',
        ], 200);
    }
}