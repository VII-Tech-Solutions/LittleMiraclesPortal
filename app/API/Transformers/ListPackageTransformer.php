<?php

namespace App\API\Transformers;

use App\Constants\Attributes;
use App\Constants\Values;
use League\Fractal\Resource\Collection;

/**
 * Class ListPackageTransformer
 * @package App\API\Transformers
 */
class ListPackageTransformer extends CustomTransformer
{
    public $fields = [
        Attributes::ID,
        Attributes::IMAGE,
        Attributes::TITLE,
        Attributes::TAG,
        Attributes::PRICE,
        Attributes::IS_POPULAR,
        Attributes::TYPE,
        Attributes::CONTENT,
        Attributes::LOCATION_TEXT,
        Attributes::LOCATION_LINK,
        Attributes::PACKAGE_BENEFITS,
        Attributes::STATUS,
        Attributes::UPDATED_AT,
        Attributes::DELETED_AT,
    ];

    protected $defaultIncludes = [
        Attributes::BENEFITS
    ];


    /**
     * Include Benefits
     * @param $item
     * @return Collection
     */
    public function includeBenefits($item)
    {
        return $this->collection($item->benefits, new IDTransformer(), Values::NO_RESOURCE_KEY);
    }
}
