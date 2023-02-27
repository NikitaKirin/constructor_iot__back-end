<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;


use App\Lib\Integrations\ProviderApiClient;
use App\Lib\Integrations\ProviderRepository;
use Illuminate\Support\Collection;

class HeadHunterRepository extends ProviderRepository
{

    private string $searchText;

    private array $vacancies = [];

    private int $vacanciesCount;


    public function __construct(private HeadHunterApiClient|ProviderApiClient $apiClient) {
    }

    public function getVacancies(): Collection {
        $result = [];
        if (empty($this->vacancies)) {
            $queryParameters = [
                'text'             => $this->searchText,
                'only_with_salary' => true,
                'page'             => 0,
                'per_page'         => 100,
                'employment'       => 'full',
            ];
            $response = $this->apiClient->loadVacancies($queryParameters);
            $this->vacanciesCount = (int)$response['found'];
            $result = array_merge($result, $response['items']);
            for ($i = 0; $i < $response['pages']; $i++) {
                if ($i === 19) {
                    break;
                }
                $newQueryParameters = array_merge($queryParameters, ['page' => $i + 1]);
                $currentResponse = $this->apiClient->loadVacancies($newQueryParameters);
                $result = array_merge($result, $currentResponse['items']);
            }
            $this->vacancies = $result;
        }


        return collect($this->vacancies);
    }

    /**
     * @return Collection
     */
    public function getVacanciesSalaries(): Collection {
        $vacancies = $this->getVacancies();
        return $vacancies->map(function ($vacancy) {
            $salaryData = collect($vacancy)->get('salary');
            if ($salaryData['currency'] !== 'RUR') {
                return null; //todo convert currency
            }
            if (is_null($salaryData['to'])) {
                $result = $salaryData['from'];
            } elseif (is_null($salaryData['from'])) {
                $result = $salaryData['to'];
            } else {
                $result = (int)(($salaryData['from'] + $salaryData['to']) / 2);
            }
            if ($result < 15000) {
                return null;
            }
            return $result;
        });
    }

    /**
     * @param string $countryName
     * @param string|null $regionName
     * @param string|null $cityName
     * @return Collection
     */
    public function getArea(string $countryName, ?string $regionName, ?string $cityName): Collection {
        $countries = collect($this->apiClient->loadAreas());
        //todo: cache areas
        $areas = $countries->filter(function ($country) use ($countryName) {
            return $country['name'] === $countryName;
        })->map(fn($country) => $country['areas'])->first();

        $resultRegion = collect($areas)->filter(fn($area) => $area['name'] === $regionName)
            ->first();
        if (isset($cityName)) {
            $resultCity = collect($resultRegion['areas'])->filter(fn($area) => $area['name'] === $cityName)->first();
            return collect($resultCity);
        }
        return collect($resultRegion);
    }

    public function setSearchText(string $searchText) {
        $this->vacancies = [];
        $this->searchText = $searchText;
    }

    public function getSpecificAreaVacanciesCount(string $countryName = "Россия",
                                                  string $regionName = null,
                                                  string $cityName = null): int {
        $area = $this->getArea($countryName, $regionName, $cityName);
        $vacancies = $this->apiClient->loadVacancies([
            'text'     => $this->searchText,
            'page'     => 0,
            'per_page' => 100,
            'area'     => $area->get('id'),
        ]);
        return $vacancies['found'];
    }

    public function getVacanciesCount(): int {
        if (!isset($this->vacanciesCount)){
            $this->getVacancies();
        }
        return $this->vacanciesCount;
    }
}
