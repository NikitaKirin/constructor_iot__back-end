<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use Illuminate\Support\Collection;

class CalculateSalary
{
    public static function getMinimalSalary(Collection $salaries): mixed {
        return $salaries->min();
    }

    public static function getMaximalSalary(Collection $salaries): mixed {
        return $salaries->max();
    }

    public static function getMedianSalary(Collection $salaries): float|int|null {
        return $salaries->median();
    }
}
