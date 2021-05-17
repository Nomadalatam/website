<?php

namespace App\Queries;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class StateDataTable
 */
class CityDataTable
{
    /**
     * @return City
     */
    public function get($input = [])
    {
        /** @var City $query */
        $query = City::with('state')->select('cities.*');
        $query->when(isset($input['states']),
            function (Builder $q) use ($input) {
                $q->where('state_id', '=', $input['states']);
            });

        return $query;
    }
}
