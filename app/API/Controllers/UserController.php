<?php

namespace App\API\Controllers;

use App\Constants\Messages;
use App\Helpers;
use Dingo\Api\Http\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\GlobalHelpers;

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

    /**
     * Delete user account
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/users/delete-account",
     *     tags={"Users"},
     *     description="User Registration",
     *     @OA\Response(response="200", description="User deleted successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     * @throws Exception
     */
    function delete(): JsonResponse
    {
        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // return response
        if($user->delete()){
            return GlobalHelpers::formattedJSONResponse(Messages::ACCOUNT_DELETED, [], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);

    }

}
