<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    // Créer un nouvel itinéraire
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'duration' => 'required|integer',
            'image' => 'nullable|string',
            'destinations' => 'required|array|min:2',
            'destinations.*.name' => 'required|string',
            'destinations.*.accommodation' => 'required|string',
            'destinations.*.places_to_visit' => 'nullable|array',
            'destinations.*.activities' => 'nullable|array',
            'destinations.*.dishes_to_try' => 'nullable|array',
        ]);

        $itinerary = Itinerary::create([
            'title' => $request->title,
            'category' => $request->category,
            'duration' => $request->duration,
            'image' => $request->image,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->destinations as $destinationData) {
            Destination::create([
                'itinerary_id' => $itinerary->id,
                'name' => $destinationData['name'],
                'accommodation' => $destinationData['accommodation'],
                'places_to_visit' => $destinationData['places_to_visit'] ?? [],
                'activities' => $destinationData['activities'] ?? [],
                'dishes_to_try' => $destinationData['dishes_to_try'] ?? [],
            ]);
        }

        return response()->json(['message' => 'Itinerary created successfully', 'itinerary' => $itinerary], 201);
    }

    // Modifier un itinéraire
    public function update(Request $request, $id)
    {
        $itinerary = Itinerary::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'duration' => 'sometimes|integer',
            'image' => 'nullable|string',
        ]);

        $itinerary->update($request->only(['title', 'category', 'duration', 'image']));

        return response()->json(['message' => 'Itinerary updated successfully', 'itinerary' => $itinerary], 200);
    }

    // Afficher tous les itinéraires
    public function index()
    {
        $itineraries = Itinerary::with('destinations')->get();
        return response()->json($itineraries, 200);
    }

    // Ajouter un itinéraire à la "liste à visiter"
    public function addToWishlist($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        Auth::user()->wishlist()->attach($itinerary->id);

        return response()->json(['message' => 'Itinerary added to wishlist'], 200);
    }


    public function search(Request $request)
{
    $query = Itinerary::query();

    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    if ($request->has('duration')) {
        $query->where('duration', '<=', $request->duration);
    }

    $itineraries = $query->with('destinations')->get();

    return response()->json($itineraries, 200);
}
}
