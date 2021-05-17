<?php

namespace App\Queries;

use App\Models\SalaryPeriod;

/**
 * Class SalaryPeriodDataTable
 */
class SalaryPeriodDataTable
{
    /**
     * @return SalaryPeriod
     */
    public function get()
    {
        /** @var SalaryPeriod $query */
        $query = SalaryPeriod::query()->select('salary_periods.*');

        return $query;
    }
}
