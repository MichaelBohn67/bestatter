<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class OpenPlzService
{
    protected string $baseUrl = 'https://www.openplzapi.org/de/Localities';

    /**
     * Search for localities by postal code.
     *
     * @param string $plz
     * @return Collection
     */
    public function getLocalitiesByPlz(string $plz): Collection
    {
        $response = Http::get($this->baseUrl, [
            'postalCode' => $plz,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Search for localities by name.
     *
     * @param string $name
     * @return Collection
     */
    public function getLocalitiesByName(string $name): Collection
    {
        $response = Http::get($this->baseUrl, [
            'name' => $name,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Search for streets within a locality.
     *
     * @param string $plz
     * @param string $name
     * @return Collection
     */
    public function getStreets(string $plz, string $name): Collection
    {
        $response = Http::get("https://www.openplzapi.org/de/Streets", [
            'postalCode' => $plz,
            'locality' => $name,
        ]);

        return $this->handleResponse($response);
    }

    protected function handleResponse($response): Collection
    {
        if ($response->failed()) {
            return collect();
        }

        return collect($response->json());
    }
}
