<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreLocatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_with_services()
    {
        $services = Service::factory()->count(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Recherche de magasins');

        foreach ($services as $service) {
            $response->assertSee($service->name);
        }
    }

    public function test_search_results_with_valid_coordinates()
    {
        $store = Store::factory()->create([
            'lat' => 48.8566,
            'lng' => 2.3522,
        ]);

        $response = $this->get('/resultats?n=49&s=48&e=3&w=2');

        $response->assertStatus(200);
        $response->assertSee($store->name);
    }

    public function test_search_results_with_services_filter()
    {
        $service = Service::factory()->create();
        $store = Store::factory()->create();
        $store->services()->attach($service->id);

        $response = $this->get("/resultats?n=49&s=48&e=3&w=2&services[]={$service->id}&operator=OR");

        $response->assertStatus(200);
        $response->assertSee($store->name);
        $response->assertSee($service->name);
    }

    public function test_store_detail_page()
    {
        $store = Store::factory()->create();
        $service = Service::factory()->create();
        $store->services()->attach($service->id);

        $response = $this->get("/magasin/{$store->id}");

        $response->assertStatus(200);
        $response->assertSee($store->name);
        $response->assertSee($store->address);
        $response->assertSee($service->name);
    }

    public function test_validation_errors_for_invalid_coordinates()
    {
        $response = $this->get('/resultats?n=invalid&s=48&e=3&w=2');

        $response->assertStatus(302); // Redirect with validation errors
    }

    public function test_store_is_open_or_closed()
    {
        $store = Store::factory()->create([
            'hours' => [
                'Monday' => ['09:00-18:00'],
                'Tuesday' => ['09:00-18:00'],
                'Wednesday' => ['09:00-18:00'],
                'Thursday' => ['09:00-18:00'],
                'Friday' => ['09:00-18:00'],
                'Saturday' => ['09:00-18:00'],
            ]
        ]);

        $response = $this->get("/magasin/{$store->id}");

        $response->assertStatus(200);
        // Should show either "Ouvert" or "Fermé"
        $response->assertSee('Ouvert');
    }
}
