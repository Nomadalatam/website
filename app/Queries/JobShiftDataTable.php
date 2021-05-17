<?php

namespace App\Queries;

use App\Models\JobShift;

/**
 * Class JobShiftDataTable
 */
class JobShiftDataTable
{
    /**
     * @return JobShift
     */
    public function get()
    {
        /** @var JobShift $query */
        $query = JobShift::query()->select('job_shifts.*');

        return $query;
    }
}
