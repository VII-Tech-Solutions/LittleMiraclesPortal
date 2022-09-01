<?php

namespace App\API\Controllers;

use App\Constants\Attributes;
use App\Constants\Messages;
use App\Helpers;
use App\Models\User;
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

    /**
     * List Firebase Ids
     * @return JsonResponse
     */
    function listFirebaseIds() {

        // get firebase ids
        $firebase_ids = User::where(Attributes::CHAT_WITH_EVERYONE, true)->pluck(Attributes::FIREBASE_ID);

        // return response
        return Helpers::returnResponse([
            Attributes::FIREBASE_IDS => $firebase_ids
        ]);
    }

}
