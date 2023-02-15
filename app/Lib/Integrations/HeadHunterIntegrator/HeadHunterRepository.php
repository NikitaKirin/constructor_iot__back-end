<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;


use App\Lib\Integrations\ProviderApiClient;
use App\Lib\Integrations\ProviderRepository;
use Illuminate\Support\Collection;

class HeadHunterRepository extends ProviderRepository
{
    public function __construct(private HeadHunterApiClient|ProviderApiClient $apiClient) {
    }

    /**
     * @return Collection
     */
    public function getVacancies(): Collection {
        $area = $this->getArea("Россия", "Свердловская область");
        $vacancies = $this->apiClient->loadVacancies([
            'text' => 'Frontend-разработчик',
            'area' => $area->get('id'),
            'only_with_salary' => true,
            'page' => 0,
        ]);
        return collect($vacancies);
    }

    /**
     * @return Collection
     */
    public function getVacanciesSalaries(): Collection {
        $vacancies = $this->getVacancies();
        return $vacancies->map(function ($vacancy) {
            $salaryData = collect($vacancy)->get('salary');
            if (is_null($salaryData['to'])) {
                return $salaryData['from'];
            } elseif (is_null($salaryData['from'])) {
                return $salaryData['to'];
            } else {
                return (int)(($salaryData['from'] + $salaryData['to']) / 2);
            }
        });
    }

    /**
     * @param string $countryName
     * @param string $areaName
     * @return Collection
     */
    public function getArea(string $countryName, string $areaName): Collection {
        $countries = collect($this->apiClient->loadAreas());
        //todo: cache areas
        $areas = $countries->filter(function ($country) use ($countryName) {
            return $country['name'] === $countryName;
        })->map(fn($country) => $country['areas'])->first();

        return collect(collect($areas)->filter(fn($area) => $area['name'] === $areaName)
            ->first());
    }
}
