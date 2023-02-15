<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use App\Lib\Integrations\IntegrationManager;

class HeadHunterIntegrationManager extends IntegrationManager
{

    protected function getApiClient(): HeadHunterApiClient {
        return new HeadHunterApiClient(HeadHunter::Domain->value);
    }

    protected function getProviderRepository(): HeadHunterRepository {
        return new HeadHunterRepository($this->getApiClient());
    }

    private function getProfessionsTitle(){

    }

    public function updateVacanciesCount() {
        $headHunterClient = $this->getApiClient();
        $headHunterRepository = $this->getProviderRepository();
    }

    public function updateVacanciesSalaries() {
        // TODO
    }
}
