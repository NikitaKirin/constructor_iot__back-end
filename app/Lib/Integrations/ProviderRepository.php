<?php

namespace App\Lib\Integrations;

abstract class ProviderRepository
{
    abstract public function __construct(ProviderApiClient $apiClient);
}
