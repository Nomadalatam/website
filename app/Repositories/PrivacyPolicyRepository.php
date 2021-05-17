<?php

namespace App\Repositories;

use App\Models\Setting;

/**
 * Class PrivacyPolicyRepository
 */
class PrivacyPolicyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
        'value',
    ];

    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Setting::class;
    }
}
