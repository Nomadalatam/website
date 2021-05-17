<?php

namespace App\Queries;

use App\Models\Candidate;

/**
 * Class ResumesDataTable
 */
class ResumesDataTable
{
    public function get()
    {
        $candidates = Candidate::with('user', 'media')->whereHas('media', function ($q) {
            $q->whereNotNull('file_name');
        })->get();

        return $candidates;
    }
}
