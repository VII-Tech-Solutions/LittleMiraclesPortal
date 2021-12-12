<?php

namespace App\API\Controllers;

use App\API\Transformers\ListSessionTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Helpers;
use App\Models\Session;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\GlobalHelpers;

/**
 * Session Controller
 */
class SessionController extends CustomController
{

    /**
     * List All Sessions
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/sessions",
     *     tags={"Sessions"},
     *     description="List Sessions",
     *     @OA\Response(response="200", description="Sessions retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function listAll(): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get sessions
        $sessions = Session::active()->where(Attributes::USER_ID, $user->id)->get();

        // get last updated items
        if(!empty($this->last_update)){
            $sessions = Helpers::getLatestOnlyInCollection($packages, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::SESSIONS => Session::returnTransformedItems($sessions, ListSessionTransformer::class),
        ]);
    }

    /**
     * Book a Session
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions",
     *     tags={"Sessions"},
     *     description="Book a Session",
     *     @OA\Response(response="200", description="Sessions saved successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function bookSession(): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get sessions
        $sessions = Session::active()->where(Attributes::USER_ID, $user->id)->get();

        // get last updated items
        if(!empty($this->last_update)){
            $sessions = Helpers::getLatestOnlyInCollection($packages, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::SESSIONS => Session::returnTransformedItems($sessions, ListSessionTransformer::class),
        ]);
    }


}
