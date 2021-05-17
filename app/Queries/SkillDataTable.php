<?php

namespace App\Queries;

use App\Models\Skill;

/**
 * Class SkillDataTable
 */
class SkillDataTable
{
    /**
     * @return Skill
     */
    public function get()
    {
        /** @var Skill $query */
        $query = Skill::query()->select('skills.*');

        return $query;
    }
}
