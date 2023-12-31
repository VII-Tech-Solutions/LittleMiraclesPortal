<?php

namespace App\API\Transformers;

use App\Constants\Attributes;
use App\Constants\Values;
use App\Models\Helpers;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

/**
 * Class CustomTransformer
 * @package App\API\Transformers
 */
class CustomTransformer extends TransformerAbstract
{
    public $fields;
    public $extra_fields;
    protected $map_extra_attributes = [];

    /**
     * CustomTransformer constructor.
     * @param null $fields
     */
    public function __construct($fields = null)
    {
        if (!is_null($fields)) {
            $this->fields = $fields;
        }
    }

    /**
     * Transform
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        if (is_null($item)) {
            $item = collect();
        }
        if (!is_null($this->extra_fields)) {
            foreach ($this->extra_fields as $key => $value) {
                $item[$key] = $item->{$value};
            }
        }
        if (!is_null($this->map_extra_attributes)) {
            foreach ($this->map_extra_attributes as $key => $value) {
                $item[$key] = $item->{$value};
            }
        }
        if(!is_array($item)){
            $item = $item->toArray();
        }
        $item = collect($item);
        if($item->has(Attributes::ID)){
            $item->put(Attributes::ID, intval($item->get(Attributes::ID)));
        }
        return $item->only($this->fields)->toArray();
    }

    /**
     * Include Benefits
     * @param $item
     * @return Collection
     */
    public function includeBenefits($item)
    {
        return $this->collection(Helpers::nullableCollection($item->benefits), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }

    /**
     * Include Benefits IDs
     * @param $item
     * @return Collection
     */
    public function includeBenefitsIds($item)
    {
        return $this->collection(Helpers::nullableCollection($item->benefits), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }

    /**
     * Include Reviews IDs
     * @param $item
     * @return Collection
     */
    public function includeReviewsIds($item)
    {
        return $this->collection(Helpers::nullableCollection($item->reviews), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }

    /**
     * Include Hours
     * @param $item
     * @return Collection
     */
    public function includeHours($item)
    {
        return $this->collection(Helpers::nullableCollection($item->hours), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }

    /**
     * Include Media IDs
     * @param $item
     * @return Collection
     */
    public function includeMediaIds($item)
    {
        return $this->collection(Helpers::nullableCollection($item->media), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }

    /**
     * Include People IDs
     * @param $item
     * @return Collection
     */
    public function includePeopleIds($item)
    {
        return $this->collection(Helpers::nullableCollection($item->people), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }

    /**
     * Include Reviews
     * @param $item
     * @return Collection
     */
    public function includeReviews($item)
    {
        return $this->collection(Helpers::nullableCollection($item->reviews), new IDTransformer(), Values::NO_RESOURCE_KEY);
    }
}
