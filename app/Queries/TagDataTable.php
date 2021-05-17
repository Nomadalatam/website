<?php

namespace App\Queries;

use App\Models\Tag;

/**
 * Class JobTagDataTable
 */
class TagDataTable
{
    /**
     * @return Tag
     */
    public function get()
    {
        /** @var Tag $query */
        $query = Tag::query()->select('tags.*');

        return $query;
    }
}
