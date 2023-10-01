<?php

namespace App\API\Controllers;

use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\SessionStatus;
use App\Models\FamilyInfo;
use App\Models\FamilyMember;
use App\Models\Helpers;
use App\Models\Session;
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

        // check booked sessions
        $booked_sessions = Session::where('user_id', $user->id)->whereNotIn('status', [SessionStatus::UNPAID, SessionStatus::READY])->count();

        // check booked orders
//        $booked_orders = Order::where('user_id', $user->id)->where('session_id', '=', null)
//            ->where('status', OrderStatus::PAID)->count();

        if ($booked_sessions > 0 /*|| $booked_orders > 0*/) {
            return GlobalHelpers::formattedJSONResponse("Sorry, you currently have bookings associated with your account, and as a result, you cannot delete your account at this time. If you still wish to proceed, please contact our support team for assistance.", null, null, Response::HTTP_BAD_REQUEST);
        }

        // delete family info and family member
        FamilyInfo::where('user_id', $user->id)->delete();
        FamilyMember::where('user_id', $user->id)->delete();

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
