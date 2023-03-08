<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use App\Lib\Integrations\IntegrationManager;
use App\Models\Profession;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class HeadHunterIntegrationManager extends IntegrationManager
{
    private HeadHunterApiClient $headHunterApiClient;

    private Collection $professions;

    protected function getApiClient(): HeadHunterApiClient {
        if (!isset($this->headHunterApiClient)) {
            $this->headHunterApiClient = new HeadHunterApiClient(HeadHunter::Domain->value);
        }
        return $this->headHunterApiClient;
    }

    protected function getProviderRepository(): HeadHunterRepository {
        return new HeadHunterRepository($this->getApiClient());
    }

    private function getProfessions(): Collection {
        if (!isset($this->professions)) {
            $allProfessions = Profession::withCount(['professionalTrajectories'])->get();
            $this->professions = $allProfessions->where('professional_trajectories_count', '>', 0);
        }
        return $this->professions;
    }

    public function updateVacanciesData() {
        $professions = $this->getProfessions();
        $professions->each(function (Profession $profession) {
            Log::info("Получаю данные по профессии : $profession->title");
            echo("Получаю данные по профессии : $profession->title" . PHP_EOL);
            $headHunterRepository = $this->getProviderRepository();
            $headHunterRepository->setSearchText($profession->headhunter_search_text);
            $vacanciesCount = $headHunterRepository->getVacanciesCount();
            $vacanciesSalaries = $headHunterRepository->getVacanciesSalaries();
            $currentAreaVacanciesCount = $headHunterRepository->getSpecificAreaVacanciesCount("Россия", "Свердловская область");
            $minimalSalary = CalculateSalary::getMinimalSalary($vacanciesSalaries);
            $maximalSalary = CalculateSalary::getMaximalSalary($vacanciesSalaries);
            $medianSalary = CalculateSalary::getMedianSalary($vacanciesSalaries);
            echo("Минимальная зарплата: " . $minimalSalary . PHP_EOL);
            echo("Максимальная зарплата: " . $maximalSalary . PHP_EOL);
            echo("Медианная зарплата: " . $medianSalary . PHP_EOL);
            echo("Общее кол-во вакансий: " . $vacanciesCount . PHP_EOL);
            echo("Кол-во вакансий по Свердловской области: " . $currentAreaVacanciesCount . PHP_EOL);
            Log::info("Обновляю данные по профессии: $profession->title", [
                'vacancies_count'      => $vacanciesCount,
                'area_vacancies_count' => $currentAreaVacanciesCount,
                'minimal_salary'       => $minimalSalary,
                'maximal_salary'       => $maximalSalary,
                'median_salary'        => $medianSalary,
                'updated_at'           => Carbon::now(),
            ]);
            $profession->update([
                'vacancies_count'      => $vacanciesCount,
                'area_vacancies_count' => $currentAreaVacanciesCount,
                'minimal_salary'       => $minimalSalary,
                'maximal_salary'       => $maximalSalary,
                'median_salary'        => $medianSalary,
                'updated_at'           => Carbon::now(),
            ]);
        });
    }
}
