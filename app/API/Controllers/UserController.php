<?php

namespace App\API\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * User Controller
 */
class UserController extends CustomController
{

    /**
     * User Registration
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/users/register",
     *     tags={"Users"},
     *     description="User Registration",
     *     @OA\Response(response="200", description="User registered successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    function register(){





    }

}
