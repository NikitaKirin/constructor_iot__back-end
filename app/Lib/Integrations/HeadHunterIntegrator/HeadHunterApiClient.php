<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use App\Lib\Integrations\ProviderApiClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeadHunterApiClient extends ProviderApiClient
{
    private array $areas = [];

    private array $defaultHeaders;

    public function loadVacancies(array $queryParameters = []): array {
        $result = [];
        $defaultHeaders = $this->getDefaultHeaders();
        $response = Http::withHeaders($defaultHeaders)->get($this->domain . 'vacancies', $queryParameters)->json();
        $result = array_merge($result, $response['items']);
        for ($i = 0; $i < $response['pages']; $i++) {
            if ($i === 19) {
                break;
            }
            $newQueryParameters = array_merge($queryParameters, ['page' => $i + 1]);
            $currentResponse = Http::retry(3, 5000)->get($this->domain . 'vacancies', $newQueryParameters)->json()['items'];
            $result = array_merge($result, $currentResponse);
        }
        return $result;
    }

    public function loadAreas() {
        $defaultHeaders = $this->getDefaultHeaders();
        if (empty($this->areas)) {
            $responce = Http::withHeaders($defaultHeaders)->get(HeadHunter::Domain->value . 'areas')->json();
            $this->areas = $responce;
        }
        return $this->areas;
    }

    private function getDefaultHeaders(): array {
        if (!isset($this->defaultHeaders)) {
            $this->defaultHeaders = [
                'User-Agent' => 'ConstructorIOT (kirinnikita1406@gmail.com)',
                'Accept' => 'application/json',
                'Authorization' => env("HEADHUNTER_TOKEN_TYPE") . ' ' . env("HEADHUNTER_ACCESS_TOKEN"),
            ];
        }
        return $this->defaultHeaders;
    }
}
