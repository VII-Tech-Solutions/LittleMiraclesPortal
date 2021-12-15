<?php

namespace App\API\Controllers;

use App\API\Transformers\ListReviewsTransformer;
use App\API\Transformers\ListSessionTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Helpers;
use App\Models\Review;
use App\Models\Session;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
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
        if(!empty($id)){
            $sessions = Session::active()->where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->get();
        }else{
            $sessions = Session::active()->where(Attributes::USER_ID, $user->id)->get();
        }

        // get last updated items
        if(!empty($this->last_update)){
            $sessions = Helpers::getLatestOnlyInCollection($sessions, $this->last_update);
        }

        // get related reviews
        $reviews = $sessions->map->reviews;
        $reviews = $reviews->flatten()->filter();

        // return response
        return Helpers::returnResponse([
            Attributes::SESSIONS => Session::returnTransformedItems($sessions, ListSessionTransformer::class),
            Attributes::REVIEWS => Review::returnTransformedItems($reviews, ListReviewsTransformer::class),
        ]);
    }

    /**
     * Get Session Info
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/sessions/{id}",
     *     tags={"Sessions"},
     *     description="Get Session Info",
     *     @OA\Response(response="200", description="Session retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     * )
     */
    public function getInfo($id): JsonResponse
    {
        $this->request->merge([
            Attributes::ID => $id
        ]);
        return $this->listAll();
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

        // TODO save all details

        // TODO return response
        return Helpers::returnResponse([
            Attributes::SESSIONS => Session::returnTransformedItems($sessions, ListSessionTransformer::class),
        ]);
    }


    /**
     * Submit a Review
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions/{id}/review",
     *     tags={"Sessions"},
     *     description="Submit a Review",
     *     @OA\Response(response="200", description="Review submitted successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function submitReview($id): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // validate session
        /** @var Session $session */
        $session = Session::where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->first();
        if (is_null($session)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SESSION, null, null, Response::HTTP_BAD_REQUEST);
        }

        $session->rating = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::RATING, null, CastingTypes::INTEGER);
        $session->comment = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COMMENT, null, CastingTypes::STRING);

        if($session->save()){
            return GlobalHelpers::formattedJSONResponse(Messages::REVIEW_SUBMITTED, [], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);

    }

    /**
     * Apply Promo Code
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions/{id}/promotion",
     *     tags={"Sessions"},
     *     description="Apply Promo Code",
     *     @OA\Response(response="200", description="Promo code applied successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function applyPromoCode($id): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // validate session
        $session = Session::where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->first();
        if (is_null($session)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SESSION, null, null, Response::HTTP_BAD_REQUEST);
        }

        // TODO validate promo code

        // TODO apply to session and return updated details

        if(true){
            return GlobalHelpers::formattedJSONResponse(Messages::PROMO_CODE_APPLIED, [], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);

    }
}
