<?php

namespace App\Queries;

use App\Models\JobType;

/**
 * Class JobTagDataTable
 */
class JobTypeDataTable
{
    /**
     * @return JobType
     */
    public function get()
    {
        /** @var JobType $query */
        $query = JobType::query()->select('job_types.*');

        return $query;
    }
}
