<?php

namespace App\Queries;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class JobCategoryDataTable
 * @package App\Queries
 */
class JobCategoryDataTable
{
    /**
     * @return JobCategory|Builder
     */
    public function get($input = [])
    {
        /** @var JobCategory $query */
        $query = JobCategory::query()->select('job_categories.*');

        $query->when(isset($input['is_featured']) && $input['is_featured'] == 1,
            function (Builder $q) use ($input) {
                $q->where('is_featured', '=', 1);
            });

        $query->when(isset($input['is_featured']) && $input['is_featured'] == 0,
            function (Builder $q) use ($input) {
                $q->where('is_featured', '=', 0);
            });

        return $query;
    }
}
