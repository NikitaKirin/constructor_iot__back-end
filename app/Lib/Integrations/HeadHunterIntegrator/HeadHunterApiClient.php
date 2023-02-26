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
        return Http::retry(3, 5000)->withHeaders($defaultHeaders)->get($this->domain . 'vacancies', $queryParameters)->json();
    }

    public function loadAreas(): array {
        $defaultHeaders = $this->getDefaultHeaders();
        if (empty($this->areas)) {
            $this->areas = Http::withHeaders($defaultHeaders)->get(HeadHunter::Domain->value . 'areas')->json();
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
