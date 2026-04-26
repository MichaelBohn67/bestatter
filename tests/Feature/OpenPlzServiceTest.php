<?php

namespace Tests\Feature;

use App\Services\OpenPlzService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OpenPlzServiceTest extends TestCase
{
    public function test_it_can_fetch_localities_by_plz()
    {
        Http::fake([
            'www.openplzapi.org/*' => Http::response([
                [
                    'postalCode' => '10115',
                    'name' => 'Berlin',
                ]
            ], 200),
        ]);

        $service = app(OpenPlzService::class);
        $results = $service->getLocalitiesByPlz('10115');

        $this->assertCount(1, $results);
        $this->assertEquals('Berlin', $results[0]['name']);
        $this->assertEquals('10115', $results[0]['postalCode']);
    }

    public function test_it_can_fetch_localities_by_name()
    {
        Http::fake([
            'www.openplzapi.org/*' => Http::response([
                [
                    'postalCode' => '10115',
                    'name' => 'Berlin',
                ]
            ], 200),
        ]);

        $service = new OpenPlzService();
        $results = $service->getLocalitiesByName('Berlin');

        $this->assertCount(1, $results);
        $this->assertEquals('Berlin', $results[0]['name']);
    }

    public function test_it_can_fetch_streets()
    {
        Http::fake([
            'www.openplzapi.org/de/Streets*' => Http::response([
                [
                    'name' => 'Alexanderplatz',
                ],
                [
                    'name' => 'Unter den Linden',
                ]
            ], 200),
        ]);

        $service = app(OpenPlzService::class);
        $results = $service->getStreets('10115', 'Berlin');

        $this->assertCount(2, $results);
        $this->assertEquals('Alexanderplatz', $results[0]['name']);
    }

    public function test_it_returns_empty_collection_on_failure()
    {
        Http::fake([
            'www.openplzapi.org/*' => Http::response([], 500),
        ]);

        $service = app(OpenPlzService::class);
        $results = $service->getLocalitiesByPlz('00000');

        $this->assertCount(0, $results);
    }
}
