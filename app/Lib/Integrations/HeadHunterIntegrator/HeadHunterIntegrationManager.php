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
    private HeadHunterRepository $headHunterRepository;

    private Collection $professions;

    protected function getApiClient(): HeadHunterApiClient {
        if (!isset($this->headHunterApiClient)) {
            $this->headHunterApiClient = new HeadHunterApiClient(HeadHunter::Domain->value);
        }
        return $this->headHunterApiClient;
    }

    protected function getProviderRepository(): HeadHunterRepository {
        if (!isset($this->headHunterRepository)) {
            $this->headHunterRepository = new HeadHunterRepository($this->getApiClient());
        }
        return $this->headHunterRepository;
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
            $headHunterRepository = $this->getProviderRepository();
            $headHunterRepository->setProfessionTitle($profession->headHunter_title);
            $vacancies = $headHunterRepository->getVacancies();
            $vacanciesCount = $vacancies->count();
            $vacanciesSalaries = $headHunterRepository->getVacanciesSalaries();
            $minimalSalary = CalculateSalary::getMinimalSalary($vacanciesSalaries);
            $maximalSalary = CalculateSalary::getMaximalSalary($vacanciesSalaries);
            $medianSalary = CalculateSalary::getMedianSalary($vacanciesSalaries);
            Log::info("Обновляю данные по профессии: $profession->title", [
                'vacancies_count' => $vacanciesCount,
                'minimal_salary' => $minimalSalary,
                'maximal_salary' => $maximalSalary,
                'median_salary' => $medianSalary,
                'updated_at' => Carbon::now(),
            ]);
            $profession->update([
                'vacancies_count' => $vacanciesCount,
                'minimal_salary' => $minimalSalary,
                'maximal_salary' => $maximalSalary,
                'median_salary' => $medianSalary,
                'updated_at' => Carbon::now(),
            ]);
        });
    }
}
