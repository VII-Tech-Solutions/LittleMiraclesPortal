<?php

namespace App\Swagger;

/**
 * Class LoginJsonResponse
 * @package App\Swagger
 *
 * @OA\Schema()
 */
class LoginJsonResponse
{

    /**
     * @OA\Property(property="message", type="string", description="Message")
     * @OA\Property(property="data", type="array", description="Data", @OA\Items(type="string"))
     * @OA\Property(property="error", type="array", description="Error", @OA\Items(type="string"))
     **/

}
