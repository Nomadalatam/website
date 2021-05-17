<?php

namespace App\Queries;

use App\Models\RequiredDegreeLevel;

/**
 * Class RequiredDegreeLevelDataTable
 */
class RequiredDegreeLevelDataTable
{
    /**
     * @return RequiredDegreeLevel
     */
    public function get()
    {
        /** @var RequiredDegreeLevel $query */
        $query = RequiredDegreeLevel::query()->select('required_degree_levels.*');

        return $query;
    }
}
