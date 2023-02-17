<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use App\Lib\Integrations\IntegrationManager;

class HeadHunterIntegrationManager extends IntegrationManager
{
    private HeadHunterApiClient $headHunterApiClient;
    private HeadHunterRepository $headHunterRepository;

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

    private function getProfessionsTitle() {

    }

    public function updateVacanciesCount() {
    }

    public function updateVacanciesSalaries() {
        // TODO
    }
}
