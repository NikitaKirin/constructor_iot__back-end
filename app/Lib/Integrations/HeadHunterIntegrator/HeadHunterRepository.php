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
        $area = $this->getArea("Россия", "Свердловская область");
        if (empty($this->vacancies)){
            $this->vacancies = $this->apiClient->loadVacancies([
                'text' => $this->professionTitle,
                //'area' => $area->get('id'),
                'only_with_salary' => true,
                'page' => 0,
                'per_page' => 100,
                'employment' => 'full',
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
            if ($salaryData['currency'] !== 'RUR'){
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

    public function setProfessionTitle(string $professionTitle) {
        $this->vacancies = [];
        $this->professionTitle = $professionTitle;
    }
}
