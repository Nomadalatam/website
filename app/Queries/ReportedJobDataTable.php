<?php

namespace App\Queries;

use App\Models\ReportedJob;

/**
 * Class ReportedJobDataTable
 */
class ReportedJobDataTable
{
    /**
     * @return ReportedJob
     */
    public function get()
    {
        /** @var ReportedJob $query */
        $query = ReportedJob::with(['user.candidate', 'job'])->select('reported_jobs.*')->orderBy('created_at', 'desc');

        return $query;
    }
}
