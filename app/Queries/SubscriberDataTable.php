<?php

namespace App\Queries;

use App\Models\NewsLetter;

/**
 * Class SubscriberDataTable
 */
class SubscriberDataTable
{
    /**
     * @return NewsLetter
     */
    public function get()
    {
        /** @var NewsLetter $query */
        $query = NewsLetter::query()->select('news_letters.*');

        return $query;
    }
}
