<?php

namespace App\Swagger;

/**
 * Class CustomJsonResponse
 * @package App\Swagger
 *
 * @OA\Schema()
 */
class CustomJsonResponse
{

    /**
     * @OA\Property(property="message", type="string", description="Message")
     * @OA\Property(property="data", type="array", description="Data", @OA\Items(type="string"))
     * @OA\Property(property="error", type="array", description="Error", @OA\Items(type="string"))
     **/

}
