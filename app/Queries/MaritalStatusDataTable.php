<?php

namespace App\Queries;

use App\Models\MaritalStatus;

/**
 * Class MaritalStatusDataTable
 */
class MaritalStatusDataTable
{
    /**
     * @return MaritalStatus
     */
    public function get()
    {
        /** @var MaritalStatus $query */
        $query = MaritalStatus::query()->select('marital_status.*');

        return $query;
    }
}
