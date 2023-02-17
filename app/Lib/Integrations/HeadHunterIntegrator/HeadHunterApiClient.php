<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use App\Lib\Integrations\ProviderApiClient;
use Illuminate\Support\Facades\Http;

class HeadHunterApiClient extends ProviderApiClient
{
    private array $areas = [];

    public function loadVacancies(array $queryParameters = []): array {
        $result = [];
        $response = Http::withHeaders([
            'User-Agent' => 'ConstructorIOT (kirinnikita1406@gmail.com)',
            'Accept' => 'application/json',
            'Authorization' => env("HEADHUNTER_TOKEN_TYPE") . ' ' . env("HEADHUNTER_ACCESS_TOKEN"),
        ])->get($this->domain . 'vacancies', $queryParameters)->json();
        $result = array_merge($result, $response['items']);
        for ($i = 1; $i < $response['pages']; $i++) {
            $newQueryParameters = array_merge($queryParameters, ['page' => $i]);
            $result = array_merge($result, Http::get($this->domain . 'vacancies', $newQueryParameters)->json()['items']);
        }
        return $result;
    }

    public function loadAreas() {
        if (empty($this->areas)) {
            $this->areas = Http::withHeaders([
                'User-Agent' => 'ConstructorIOT (kirinnikita1406@gmail.com)',
                'Accept' => 'application/json',
                'Authorization' => env("HEADHUNTER_TOKEN_TYPE") . ' ' . env("HEADHUNTER_ACCESS_TOKEN"),
            ])->get(HeadHunter::Domain->value . 'areas')->json();
        }
        return $this->areas;
    }
}
