<?php

namespace App\API\Serializers;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class CustomArraySerializer
 * @package App\API\Serializers
 */
class CustomArraySerializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
