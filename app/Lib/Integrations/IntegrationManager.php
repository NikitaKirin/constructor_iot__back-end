<?php

namespace App\Lib\Integrations;

abstract class IntegrationManager
{
    abstract protected function getApiClient(): ProviderApiClient;

    abstract protected function getProviderRepository(): ProviderRepository;
}
