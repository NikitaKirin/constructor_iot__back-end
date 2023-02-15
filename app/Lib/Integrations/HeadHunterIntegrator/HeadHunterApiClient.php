<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use App\Lib\Integrations\ProviderApiClient;
use Illuminate\Support\Facades\Http;

class HeadHunterApiClient extends ProviderApiClient
{
    public function loadVacancies(array $queryParameters = []): array {
        $result = [];
        $response = Http::get($this->domain . 'vacancies', $queryParameters)->json();
        $result = array_merge($result, $response['items']);
        for ($i = 1; $i < $response['pages']; $i++) {
            $newQueryParameters = array_merge($queryParameters, ['page' => $i]);
            $result = array_merge($result, Http::get($this->domain . 'vacancies', $newQueryParameters)->json()['items']);
        }
        return $result;
    }

    public function loadAreas() {
        //todo: cache areas
        return Http::withHeaders([
            'User-Agent' => 'ConstructorIOT (kirinnikita1406@gmail.com)',
            'Accept' => 'application/json'
        ])->get(HeadHunter::Domain->value . 'areas')->json();
    }
}
