<?php

namespace App\Queries;

use App\Models\State;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class StateDataTable
 */
class StateDataTable
{
    /**
     * @return State
     */
    public function get($input = [])
    {
        /** @var State $query */
        $query = State::with('country')->select('states.*');
        $query->when(isset($input['country']),
            function (Builder $q) use ($input) {
                $q->where('country_id', '=', $input['country']);
            });

        return $query;
    }
}
