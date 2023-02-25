<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;


use App\Lib\Integrations\ProviderApiClient;
use App\Lib\Integrations\ProviderRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class HeadHunterRepository extends ProviderRepository
{

    private string $professionTitle;

    private array $vacancies = [];


    public function __construct(private HeadHunterApiClient|ProviderApiClient $apiClient) {
    }

    public function getVacancies(): Collection {
        if (empty($this->vacancies)) {
            $this->vacancies = $this->apiClient->loadVacancies([
                'text'             => $this->professionTitle,
                'only_with_salary' => true,
                'page'             => 0,
                'per_page'         => 100,
                'employment'       => 'full',
            ]);
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
     * @param string $regionName
     * @param string|null $cityName
     * @return Collection
     */
    public function getArea(string $countryName, string $regionName, ?string $cityName = null): Collection {
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

    public function setProfessionTitle(string $professionTitle) {
        $this->vacancies = [];
        $this->professionTitle = $professionTitle;
    }

    public function getTotalAreaVacanciesCount(): int {
        $area = $this->getArea("Россия", "Свердловская область");
        $vacancies = $this->apiClient->loadVacancies([
            'text'     => $this->professionTitle,
            'page'     => 0,
            'per_page' => 100,
            'area'     => $area->get('id'),
        ]);
        return collect($vacancies)->count();
    }
}
