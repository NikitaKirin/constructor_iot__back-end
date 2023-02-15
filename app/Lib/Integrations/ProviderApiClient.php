<?php

namespace App\Lib\Integrations;


abstract class ProviderApiClient
{
    /**
     * @param string $domain
     * @param array|null $keys
     */
    public function __construct(protected string $domain, protected array|null $keys = null) {
    }
}
