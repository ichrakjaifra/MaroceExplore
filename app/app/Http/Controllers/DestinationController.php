<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Itineraires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , $itinerary_id)
    {
        $request->validate([
          'name' => 'required',
          'accommodation' => 'required',
          'places_to_visit' => 'required',
          'activities' => 'required',
          'dishes_to_try' => 'required'
        ]);
        $createDestination = Destination::create([
          'itinerary_id'  => $itinerary_id,
          'name'          => $request->name,
          'accommodation'          => $request->accommodation,
          'places_to_visit'          => $request->places_to_visit,
          'activities'          => $request->activities,
          'dishes_to_try'          => $request->dishes_to_try,
        ]);
        if($createDestination){
            return response()->json([
              'message' => "created"
            ]);
        }else{
            return  response()->json([
              'message' => "not created"
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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
        $itinerary = Itineraires::where('user_id', Auth::id())
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Trouver la destination
        $destination = Destination::findOrFail($id);

        // Vérifier que l'itinéraire associé appartient à l'utilisateur connecté
        $itinerary = Itineraires::where('user_id', Auth::id())
            ->findOrFail($destination->itinerary_id);

        // Supprimer la destination
        $destination->delete();

        return response()->json([
            'message' => 'Destination deleted successfully',
        ], 200);
    }
}
