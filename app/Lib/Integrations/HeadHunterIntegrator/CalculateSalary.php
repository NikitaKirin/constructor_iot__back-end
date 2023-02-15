<?php

namespace App\Lib\Integrations\HeadHunterIntegrator;

use Illuminate\Support\Collection;

class CalculateSalary
{
    public static function getMinimalSalary(Collection $salaries){
        return $salaries->min();
    }

    public static function getMaximalSalary(Collection $salaries){
        return $salaries->max();
    }
}
