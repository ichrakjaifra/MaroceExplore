<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Itinerary;

class ItineraryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_itinerary()
    {
        // Créer un utilisateur pour simuler l'authentification
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Données de test pour l'itinéraire
        $data = [
            'title' => 'Explore Morocco',
            'category' => 'Adventure',
            'duration' => 7,
            'image' => 'https://example.com/morocco.jpg',
            'destinations' => [
                [
                    'name' => 'Marrakech',
                    'accommodation' => 'Riad Dar Zaman',
                    'places_to_visit' => ['Jemaa el-Fna', 'Majorelle Garden'],
                    'activities' => ['Camel Ride', 'Shopping'],
                    'dishes_to_try' => ['Tagine', 'Couscous'],
                ],
                [
                    'name' => 'Chefchaouen',
                    'accommodation' => 'Casa Perleta',
                    'places_to_visit' => ['Blue Streets', 'Ras El Maa'],
                    'activities' => ['Hiking', 'Photography'],
                    'dishes_to_try' => ['Harira', 'Mint Tea'],
                ],
            ],
        ];

        // Envoyer une requête POST pour créer un itinéraire
        $response = $this->postJson('/api/itineraries', $data);

        // Vérifier que la réponse est correcte
        $response->assertStatus(201)
                ->assertJson(['message' => 'Itinerary created successfully']);
    }
}