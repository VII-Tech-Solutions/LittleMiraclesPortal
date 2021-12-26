<?php

namespace App\API\Controllers;

use App\API\Transformers\ListMediaTransformer;
use App\API\Transformers\ListPackageBenefitTransformer;
use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListReviewsTransformer;
use App\API\Transformers\ListSessionTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\SessionDetailsType;
use App\Constants\SessionStatus;
use App\Helpers;
use App\Models\Benefit;
use App\Models\Package;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Session;
use App\Models\SessionDetail;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;
use Carbon\Carbon;

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

        // get related packages
        $packages = $sessions->map->package;
        $packages = $packages->flatten()->filter();

        // get package benefits
        $benefits = $packages->map->benefits;
        $benefits = $benefits->flatten()->filter();

        // image examples
        $media = $sessions->map->media;
        $media = $media->flatten()->filter();

        // return response
        return Helpers::returnResponse([
            Attributes::SESSIONS => Session::returnTransformedItems($sessions, ListSessionTransformer::class),
            Attributes::PACKAGES => Package::returnTransformedItems($packages, ListPackageTransformer::class),
            Attributes::REVIEWS => Review::returnTransformedItems($reviews, ListReviewsTransformer::class),
            Attributes::BENEFITS => Benefit::returnTransformedItems($benefits, ListPackageBenefitTransformer::class),
            Attributes::MEDIA => Benefit::returnTransformedItems($media, ListMediaTransformer::class),
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

        // get all parameters
        $package_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PACKAGE_ID, null, CastingTypes::INTEGER);
        $date = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DATE, null, CastingTypes::STRING);
        $time = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TIME, null, CastingTypes::STRING);
        $people = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PEOPLE, null, CastingTypes::ARRAY);
        $backdrops = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::BACKDROPS, null, CastingTypes::ARRAY);
        $cakes = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CAKES, null, CastingTypes::ARRAY);
        $comments = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COMMENTS, null, CastingTypes::STRING);
        $photographer = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PHOTOGRAPHER, null, CastingTypes::INTEGER);
        $additions = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ADDITIONS, null, CastingTypes::ARRAY);
        $payment_method = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAYMENT_METHOD, null, CastingTypes::INTEGER);
        $include_me = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::INCLUDE_ME, null, CastingTypes::BOOLEAN);


        // Get package then validate
        /** @var Package $package */
        $package = Package::where(Attributes::ID, $package_id)->first();
        if (is_null($package)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_PACKAGE, null, null, Response::HTTP_BAD_REQUEST);
        }

        // calculate package price
        $total_price = $package->price;

        // find the package
        /** @var Package $package */
        $package = Package::find($package_id);
        if(is_null($package)){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_PACKAGE, null, null, Response::HTTP_NOT_FOUND);
        }

        // create session
        $session = Session::createOrUpdate([
            Attributes::TITLE => $package->title . " on " . $date . " by " . $user->full_name,
            Attributes::USER_ID => $user->id,
            Attributes::FAMILY_ID => $user->family_id,
            Attributes::PACKAGE_ID => $package_id,
            Attributes::DATE => $date,
            Attributes::TIME => $time,
            Attributes::COMMENTS => $comments,
            Attributes::PAYMENT_METHOD => $payment_method,
            Attributes::STATUS => SessionStatus::BOOKED,
            Attributes::TOTAL_PRICE => $total_price,
            Attributes::PHOTOGRAPHER => $photographer,
            Attributes::INCLUDE_ME => $include_me
        ]);

        // save session people
        foreach ($people as $item){
            SessionDetail::createOrUpdate([
                Attributes::TYPE => SessionDetailsType::PEOPLE,
                Attributes::VALUE => $item,
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::SESSION_ID => $session->id,
                Attributes::PACKAGE_ID => $session->package_id
            ]);
        }

        // save session backdrops
        foreach ($backdrops as $item){
            SessionDetail::createOrUpdate([
                Attributes::TYPE => SessionDetailsType::BACKDROP,
                Attributes::VALUE => $item,
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::SESSION_ID => $session->id,
                Attributes::PACKAGE_ID => $session->package_id
            ]);
        }

        // save session cakes
        foreach ($cakes as $item){
            SessionDetail::createOrUpdate([
                Attributes::TYPE => SessionDetailsType::CAKE,
                Attributes::VALUE => $item,
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::SESSION_ID => $session->id,
                Attributes::PACKAGE_ID => $session->package_id
            ]);
        }

        // save session additions
        foreach ($additions as $item){
            SessionDetail::createOrUpdate([
                Attributes::TYPE => SessionDetailsType::ADDITIONS,
                Attributes::VALUE => $item,
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::SESSION_ID => $session->id,
                Attributes::PACKAGE_ID => $session->package_id
            ]);
        }

        // return response
        return $this->getInfo($session->id);
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

        // create review
        $review = Review::createOrUpdate([
            Attributes::RATING => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::RATING, null, CastingTypes::INTEGER),
            Attributes::COMMENT => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COMMENT, null, CastingTypes::STRING),
            Attributes::USER_ID => $user->id,
            Attributes::SESSION_ID => $session->id,
            Attributes::PACKAGE_ID => $session->package_id,
            Attributes::USER_IMAGE => $user->avatar,
            Attributes::USER_NAME => $user->full_name,
        ]);

        // return response
        if(is_a($review, Review::class)){
            return GlobalHelpers::formattedJSONResponse(Messages::REVIEW_SUBMITTED, [
                Attributes::REVIEWS => Review::returnTransformedItems($session->reviews, ListReviewsTransformer::class),
            ], null, Response::HTTP_OK);
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

        $code=GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CODE, null, CastingTypes::STRING);


        if(!is_null($code)){

            $promotion = Promotion::where(Attributes::PROMO_CODE, $code)->first();
            $session_code = $session->promo_id;

            if(!is_null($session_code)){
                return GlobalHelpers::formattedJSONResponse(Messages::SESSION_HAVE_A_PROMOTION_CODE, null, null, Response::HTTP_UNAUTHORIZED);
            }
            if($promotion){
                $valid=$promotion->valid_until;

                if(Carbon::parse($valid)->gte(Carbon::now())){
                    //calculate
                    $offer = $promotion->offer;
                    $price= $session->total_price * ($offer/100);

                    // add promotion ID and update the total price
                    $booked_session = Session::createOrUpdate([
                        Attributes::ID => $session->id,
                        Attributes::USER_ID => $session->user_id,
                        Attributes::PACKAGE_ID => $session->package_id,
                        Attributes::DATE => $session->date,
                        Attributes::TIME => $session->time,
                        Attributes::STATUS => $session->status,
                        Attributes::TOTAL_PRICE => $price,
                        Attributes::PROMO_ID => $promotion->id,
                    ]);

                    // return response
                    if(is_a($booked_session, Session::class)){
                        return GlobalHelpers::formattedJSONResponse(Messages::PROMO_CODE_APPLIED, null, null, Response::HTTP_OK);
                    }

                }else{
                    return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
                }

            }else{
                return GlobalHelpers::formattedJSONResponse(Messages::PROMOTION_CODE_EXPIRED, null, null, Response::HTTP_BAD_REQUEST);
            }
        }



        // TODO validate promo code

        // TODO apply to session and return updated details

        if(true){
            return GlobalHelpers::formattedJSONResponse(Messages::PROMO_CODE_APPLIED, [], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);

    }
}
