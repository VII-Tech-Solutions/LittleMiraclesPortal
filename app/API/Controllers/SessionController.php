<?php

namespace App\API\Controllers;

use App\API\Transformers\ListMediaTransformer;
use App\API\Transformers\ListPackageBenefitTransformer;
use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListReviewsTransformer;
use App\API\Transformers\ListSessionTransformer;
use App\API\Transformers\ListSubSessionTransformer;
use App\Constants\AllPackages;
use App\Constants\Attributes;
use App\Constants\Gender;
use App\Constants\Messages;
use App\Constants\PromotionStatus;
use App\Constants\PromotionType;
use App\Constants\Relationship;
use App\Constants\SessionDetailsType;
use App\Constants\SessionStatus;
use App\Constants\Status;
use App\Constants\Values;
use App\Helpers;
use App\Models\Appointment;
use App\Models\Benefit;
use App\Models\Feedback;
use App\Models\FeedbackQuestion;
use App\Models\Package;
use App\Models\Photographer;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Session;
use App\Models\SessionDetail;
use Carbon\Carbon;
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
        $location_link = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::LOCATION_LINK, null, CastingTypes::STRING);
        $extra_people = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::EXTRA_PEOPLE, null, CastingTypes::STRING);

        // Get package then validate
        /** @var Package $package */
        $package = Package::where(Attributes::ID, $package_id)->first();
        if (is_null($package)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_PACKAGE, null, null, Response::HTTP_BAD_REQUEST);
        }

        // get photographer
        /** @var Photographer $session_photographer */
        $session_photographer = Photographer::find($photographer);

        // calculate package price
        $total_price = $package->price;
        if (!is_null($session_photographer->additional_charge)) {
            $total_price += $session_photographer->additional_charge;
        }

        // find the package
        /** @var Package $package */
        $package = Package::find($package_id);
        if (is_null($package)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_PACKAGE, null, null, Response::HTTP_NOT_FOUND);
        }

        // location
        $is_outdoor = false;
        if (!is_null($location_link)) {
            $is_outdoor = true;
            $location_text = "Outdoor";
        } else {
            $location_text = "Studio";
            $location_link = null;
        }
        $package = Package::findOrfail($package_id);
//        $cakes = array_slice($cakes,-$package->cake_allowed,null,true);
//        $backdrops = array_slice($backdrops,-$package->backdrop_allowed,null,true);
        // create session
        $session = Session::createOrUpdate([
            Attributes::TITLE => $package->title . " " . $package->tag,
            Attributes::USER_ID => $user->id,
            Attributes::FAMILY_ID => $user->family_id,
            Attributes::PACKAGE_ID => $package_id,
            Attributes::SUB_PACKAGE_ID => null,
            Attributes::DATE => $date,
            Attributes::TIME => $time,
            Attributes::COMMENTS => $comments,
            Attributes::PAYMENT_METHOD => $payment_method,
            Attributes::STATUS => SessionStatus::UNPAID,
            Attributes::TOTAL_PRICE => $total_price,
            Attributes::PHOTOGRAPHER => $photographer,
            Attributes::INCLUDE_ME => $include_me,
            Attributes::LOCATION_LINK => $location_link,
            Attributes::LOCATION_TEXT => $location_text,
            Attributes::IS_OUTDOOR => $is_outdoor,
            Attributes::EXTRA_PEOPLE => $extra_people
        ],[
            Attributes::PACKAGE_ID, Attributes::USER_ID, Attributes::DATE, Attributes::TIME
        ]);
        SessionDetail::where(Attributes::SESSION_ID,$session->id)->whereIn(Attributes::TYPE,[3,2])->forceDelete();
        // save session people
        if (!is_null($people) && count($people) > 0) {
            foreach ($people as $item) {
                SessionDetail::createOrUpdate([
                    Attributes::TYPE => SessionDetailsType::PEOPLE,
                    Attributes::VALUE => $item,
                    Attributes::USER_ID => $user->id,
                    Attributes::FAMILY_ID => $user->family_id,
                    Attributes::SESSION_ID => $session->id,
                    Attributes::PACKAGE_ID => $session->package_id
                ], [
                    Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                ]);
            }
        }

        // save session backdrops
        if (!is_null($backdrops) && count($backdrops) > 0) {
            foreach ($backdrops as $item) {
                SessionDetail::createOrUpdate([
                    Attributes::TYPE => SessionDetailsType::BACKDROP,
                    Attributes::VALUE => $item,
                    Attributes::USER_ID => $user->id,
                    Attributes::FAMILY_ID => $user->family_id,
                    Attributes::SESSION_ID => $session->id,
                    Attributes::PACKAGE_ID => $session->package_id
                ],[
                    Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                ]);
            }
        }

        // save session cakes
        if (!is_null($cakes) && count($cakes) > 0) {
            foreach ($cakes as $item) {
                SessionDetail::createOrUpdate([
                    Attributes::TYPE => SessionDetailsType::CAKE,
                    Attributes::VALUE => $item,
                    Attributes::USER_ID => $user->id,
                    Attributes::FAMILY_ID => $user->family_id,
                    Attributes::SESSION_ID => $session->id,
                    Attributes::PACKAGE_ID => $session->package_id
                ],[
                    Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                ]);
            }
        }

        // save session additions
        if (!is_null($additions) && count($additions) > 0) {
            foreach ($additions as $item) {
                SessionDetail::createOrUpdate([
                    Attributes::TYPE => SessionDetailsType::ADDITIONS,
                    Attributes::VALUE => $item,
                    Attributes::USER_ID => $user->id,
                    Attributes::FAMILY_ID => $user->family_id,
                    Attributes::SESSION_ID => $session->id,
                    Attributes::PACKAGE_ID => $session->package_id
                ],[
                    Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                ]);
            }
        }

        // return response
        return $this->getInfo($session->id);
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
    public function bookMultipleSession(): JsonResponse
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
        $comments = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COMMENTS, null, CastingTypes::STRING);
        $payment_method = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAYMENT_METHOD, null, CastingTypes::INTEGER);
        $sub_sessions = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::SUB_SESSIONS, null, CastingTypes::ARRAY);


        // find the package
        /** @var Package $package */
        $package = Package::find($package_id);
        if (is_null($package)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_PACKAGE, null, null, Response::HTTP_NOT_FOUND);
        }

        if(!is_array($sub_sessions)){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }


        // calculate package price
        $total_price = $package->price;

        // create or update the session
        $session = Session::createOrUpdate([
            Attributes::TITLE => $package->title . " " . $package->tag,
            Attributes::USER_ID => $user->id,
            Attributes::FAMILY_ID => $user->family_id,
            Attributes::PACKAGE_ID => $package_id,
            Attributes::DATE => $date,
            Attributes::COMMENTS => $comments,
            Attributes::TIME => $time,
            Attributes::PAYMENT_METHOD => $payment_method,
            Attributes::STATUS => SessionStatus::UNPAID,
            Attributes::TOTAL_PRICE => $total_price,
        ],[
            Attributes::PACKAGE_ID, Attributes::USER_ID, Attributes::DATE, Attributes::TIME
        ]);

        foreach ($sub_sessions as $sub_session){

            $sub_package_id = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::SUB_PACKAGE_ID, null, CastingTypes::INTEGER);
            $date = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::DATE, null, CastingTypes::STRING);
            $time = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::TIME, null, CastingTypes::STRING);
            $people = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::PEOPLE, null, CastingTypes::ARRAY);
            $backdrops = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::BACKDROPS, null, CastingTypes::ARRAY);
            $cakes = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::CAKES, null, CastingTypes::ARRAY);
            $photographer = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::PHOTOGRAPHER, null, CastingTypes::INTEGER);
            $additions = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::ADDITIONS, null, CastingTypes::ARRAY);
            $include_me = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::INCLUDE_ME, null, CastingTypes::BOOLEAN);
            $location_link = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::LOCATION_LINK, null, CastingTypes::STRING);
            $extra_people = GlobalHelpers::getValueFromHTTPRequest($sub_session, Attributes::EXTRA_PEOPLE, null, CastingTypes::STRING);


            // check sub package
            $sub_package = $package->subpackages->where(Attributes::ID, $sub_package_id)->first();

            if (is_null($sub_package)) {
                return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SUB_PACKAGE, null, null, Response::HTTP_NOT_FOUND);
            }


            // location
            $is_outdoor = false;
            if (!is_null($location_link)) {
                $is_outdoor = true;
                $location_text = "Outdoor";
            } else {
                $location_text = "Studio";
                $location_link = null;
            }

            // get photographer
            /** @var Photographer $session_photographer */
            $session_photographer = Photographer::find($photographer);

            // calculate package price
            $total_price = $package->price;
            if (!is_null($session_photographer->additional_charge)) {
                $total_price += $session_photographer->additional_charge;
            }

            // create session
            $sub_session = Session::createOrUpdate([
                Attributes::TITLE => $sub_package->title . " " . 'Session',
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::PACKAGE_ID => $package_id,
                Attributes::SESSION_ID => $session->id,
                Attributes::SUB_PACKAGE_ID => $sub_package_id,
                Attributes::DATE => $date,
                Attributes::TIME => $time,
                Attributes::STATUS => SessionStatus::UNPAID,
                Attributes::PAYMENT_METHOD => $payment_method,
                Attributes::PHOTOGRAPHER => $photographer,
                Attributes::INCLUDE_ME => $include_me,
                Attributes::LOCATION_LINK => $location_link,
                Attributes::LOCATION_TEXT => $location_text,
                Attributes::IS_OUTDOOR => $is_outdoor,
                Attributes::TOTAL_PRICE => $total_price,
                Attributes::EXTRA_PEOPLE => $extra_people
            ],[
                Attributes::SESSION_ID, Attributes::SUB_PACKAGE_ID, Attributes::PACKAGE_ID, Attributes::USER_ID
            ]);

            // save session people
            if (!is_null($people) && count($people) > 0) {
                foreach ($people as $item) {
                    SessionDetail::createOrUpdate([
                        Attributes::TYPE => SessionDetailsType::PEOPLE,
                        Attributes::VALUE => $item,
                        Attributes::USER_ID => $user->id,
                        Attributes::FAMILY_ID => $user->family_id,
                        Attributes::SESSION_ID => $sub_session->id,
                        Attributes::PACKAGE_ID => $sub_session->package_id
                    ], [
                        Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                    ]);
                }
            }

            // save session backdrops
            if (!is_null($backdrops) && count($backdrops) > 0) {
                foreach ($backdrops as $item) {
                    SessionDetail::createOrUpdate([
                        Attributes::TYPE => SessionDetailsType::BACKDROP,
                        Attributes::VALUE => $item,
                        Attributes::USER_ID => $user->id,
                        Attributes::FAMILY_ID => $user->family_id,
                        Attributes::SESSION_ID => $sub_session->id,
                        Attributes::PACKAGE_ID => $sub_session->package_id
                    ],[
                        Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                    ]);
                }
            }

            // save session cakes
            if (!is_null($cakes) && count($cakes) > 0) {
                foreach ($cakes as $item) {
                    SessionDetail::createOrUpdate([
                        Attributes::TYPE => SessionDetailsType::CAKE,
                        Attributes::VALUE => $item,
                        Attributes::USER_ID => $user->id,
                        Attributes::FAMILY_ID => $user->family_id,
                        Attributes::SESSION_ID => $sub_session->id,
                        Attributes::PACKAGE_ID => $sub_session->package_id
                    ],[
                        Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                    ]);
                }
            }

            // save session additions
            if (!is_null($additions) && count($additions) > 0) {
                foreach ($additions as $item) {
                    SessionDetail::createOrUpdate([
                        Attributes::TYPE => SessionDetailsType::ADDITIONS,
                        Attributes::VALUE => $item,
                        Attributes::USER_ID => $user->id,
                        Attributes::FAMILY_ID => $user->family_id,
                        Attributes::SESSION_ID => $sub_session->id,
                        Attributes::PACKAGE_ID => $sub_session->package_id
                    ],[
                        Attributes::USER_ID, Attributes::SESSION_ID, Attributes::TYPE, Attributes::VALUE
                    ]);
                }
            }



        }

        // return response
        $this->request->merge([
            Attributes::ID => $session->id
        ]);

        if(!empty($session->id)){
            return $this->listAll();
        }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);



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
        $id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ID, null, CastingTypes::STRING);
        $ids = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::IDS, null, CastingTypes::ARRAY);

        //only get sessions and not sub_sessions
        $sessions = Session::sessions();
        if (!empty($id)) {
            $sessions = $sessions->where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->sortByLatest()->get();
        }elseif (!empty($ids)) {
            $sessions = $sessions->whereIn(Attributes::ID, $ids)->where(Attributes::USER_ID, $user->id)->sortByLatest()->get();
        }  else {
            $sessions = $sessions->paid()->where(Attributes::USER_ID, $user->id)->sortByLatest()->get();
        }

        // get last updated items
        if (!empty($this->last_update)) {
            $sessions = Helpers::getLatestOnlyInCollection($sessions, $this->last_update);
        }

        // get related sub_session
        $sub_session = $sessions->map->subSessions;
        $sub_session = $sub_session->flatten()->filter();

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
        $media = collect();
        foreach ( $sessions->map->media  as $session_media){
            $media->add($session_media);
        }
        foreach ( $sub_session->map->media  as $sub_session_media){
            $media->add($sub_session_media);
        }
        $media = $media->flatten()->filter()->unique(Attributes::ID);

        // return response
        return Helpers::returnResponse([
            Attributes::SESSIONS => Session::returnTransformedItems($sessions, ListSessionTransformer::class),
            Attributes::SUB_SESSIONS => Session::returnTransformedItems($sub_session, ListSubSessionTransformer::class),
            Attributes::PACKAGES => Package::returnTransformedItems($packages, ListPackageTransformer::class),
            Attributes::REVIEWS => Review::returnTransformedItems($reviews, ListReviewsTransformer::class),
            Attributes::BENEFITS => Benefit::returnTransformedItems($benefits, ListPackageBenefitTransformer::class),
            Attributes::MEDIA => Benefit::returnTransformedItems($media, ListMediaTransformer::class),
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
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
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
        if (is_a($review, Review::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::REVIEW_SUBMITTED, [
                Attributes::REVIEWS => Review::returnTransformedItems($session->reviews, ListReviewsTransformer::class),
            ], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);

    }

    /**
     * Show Guideline
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/sessions/{id}/guideline",
     *     tags={"Sessions"},
     *     description="Show Session Guideline",
     *     @OA\Response(response="200", description="Guideline generated successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     * )
     */
    public function showGuideline($id): JsonResponse
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

        $gender_type = null;
        $children_count = 0;
        $children_count2 = 0;
        $children_name = [];
        $name = [];
        $children = $session->people()->get()->where(Attributes::RELATIONSHIP, Relationship::CHILDREN);

        foreach ($children as $child) {
            $children_count++;
            $gender_type = $child->gender;
            $children_name[$children_count] = $child->first_name;
        }

        if ($children_count == 2) {
            foreach ($children_name as $names) {
                $name[$children_count2] = $names . "&";
                $children_count2++;
            }
            $name[count($name) - 1] = str_replace('&', "", $name[count($name) - 1]);
            $object = "their";
            $object2 = "they";
            $object3 = "them";
            $baby = "babies";
            $had = "have";
            $is = "are";
        } else if ($children_count > 1) {
            foreach ($children_name as $names) {
                $name[$children_count2] = $names . ",";
                $children_count2++;
            }
            $name[count($name) - 1] = str_replace(',', "", $name[count($name) - 1]);
            $object = "their";
            $object2 = "they";
            $object3 = "them";
            $baby = "babies";
            $had = "have";
            $is = "are";
        } else {
            foreach ($children_name as $names) {
                $name[$children_count2] = $names;
            }
            if ($gender_type == Gender::MALE) {
                $object = "his";
                $object2 = "he";
                $object3 = "him";
            } else if ($gender_type == Gender::FEMALE) {
                $object = "her";
                $object3 = "her";
                $object2 = "she";
            }
            $baby = "baby";
            $had = "had";
            $is = "is";
        }

        // greeting title
        if ($user->gender == Gender::FEMALE) {
            $greeting = "mommy";
        } else {
            $greeting = "daddy";
        }

        // generate text
        $text = "Hi $greeting $user->first_name!

Congratulations!! 😊

As for preparing your little miracle " . implode($name) . " for $object  photography debut, here is a guide that will help you get $object3 ready for the session:

90 minutes before you have to leave the house, wake $object3 up.  You do this by giving $object3 a bath.  Give $object3 a nice warm bath (for at least 15 minutes).  But not warm enough $object2'll fall back to sleep..

Then, give $object3 a nice BIG feed.  Make sure to burp $object3! (we don’t want gas to settle into $object tummy and upset $object3 during the session). 

When you dress $object3, only put on clothes that I do not have to take off over their head.  Please dress $baby in a zipper up sleeper with no undershirt. Anything that does up but does NOT have to be pulled up and over $object head.  This way if $object3 $is sleeping –$object2'll stay asleep when I undress $object3 😊 

If $object2 $had been introduced to a bottle, I ask that you pump and bring a few bottles for the session. $object2'll eat faster, therefore sleep quickly and we will get more poses from $object3 :)  We want $object3 sleeping – not because it’s cute, but because it’s SAFE.  I don’t put babies in props if they are awake (safety first).  Plus if $object3 choose to cluster feed this day due to growing, $object2 will get much fuller much faster which will give us a very happy, full, content and sleeping $baby.

I will do family shots for you, so keep your clothes light for the family picture (depending on where you want to put family pictures in your home) you have the option of light colors, or dark – you can wear black and we can do the family pictures on black.  A much different look so depends on your vision.  Wear black, or light colors - the choice is yours.

Please have a soother/ pacifier.  This could save the session if $object2 $is rooting a lot.  I touch $object cheeks quite a bit during sessions, so $object2 tend to root around even if $object2 $is" . "n't hungry…

Other info:
The place should be warm around 30 degrees. This is to keep naked baby happy. Please dress lightly. Husbands are welcome to stay. Please note that they need to be aware of the length and temperature of sessions. If husbands are restless, I feel rushed. This is not a benefit to either of us. Some husbands will come and get everyone settled and then leave to run errands etc.

I am not a photographer that likes to use many busy “props”. If you have something that is sentimental, and an absolute must, i will try to work it in. Keep in mind, I do not use anything that might be an unsafe prop for your newborn. If baby is not sleeping well, I may not use the item if it is at all risky. I ask that you please keep it limited to ONE item, and please let me know before session day, so that I can plan ahead for it.

If you, your wife or other children are being photographed and are looking for ideas of clothing choice/colours, this is what I recommend:

Neutrals, beiges, creams, white, greys, browns, or pastel colours. Nothing loud, bright, or any writing on shirts. I personally like skin to skin if dad is willing to go shirtless. I also like moms in tank tops if comfortable. Easiest is white or black tshirt for dad, and white or black tank top for mom. For little girls a simple soft coloured or white sundress is perfect. For boys jeans and either shirtless or plain soft coloured tshirt works well. This is my opinion, and these are your images, so in the end, wear what represents you the best. 

Please keep makeup natural, and no bright nail polish, or watches. These images will be from the waist up. 

Please do not schedule any other appointments for session day. This will cause extra stress for you and baby will sense it. 

Occasionally I have had a baby that just does not sleep, or is extremely fussy during the session. If this is the case, and I have assessed how the session is going, I may ask you to return a different day. This has only happened a couple of times, but is always a possibility.

I want you come in, sit back and relax! Let me take care of it all and enjoy your little ones first photo shoot! If you have any questions, please let me know.  

This session is amazing and you will love the images! 

See you soon! 😊

xox";

        // return response
        if (!empty($text)) {
            return GlobalHelpers::formattedJSONResponse(Messages::GUIDELINE_GENERATED_SUCCESSFULLY, [
                Attributes::GUIDELINE => $text,
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
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="code", in="query", description="Promo Code", required=true, @OA\Schema(type="string")),
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
        /** @var Session $session */
        $session = Session::where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->WhereNull(Attributes::SESSION_ID)->first();
        if (is_null($session)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SESSION, null, null, Response::HTTP_BAD_REQUEST);
        }

        // get parameters
        $code = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::CODE, null, CastingTypes::STRING);

        // validate code
        if (!is_null($code)) {

            // promo used in session
            if (!is_null($session->promo_id)) {
                return GlobalHelpers::formattedJSONResponse(Messages::SESSION_HAS_A_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
            }

            // get promotion
            /** @var Promotion $promotion */
            $promotion = Promotion::active()->where(Attributes::PROMO_CODE, $code)->first();
            if (!is_null($promotion)) {
                // check if the package id doesn't match the current session package id and if it is not 0 -> then it is false since "0" is All packages
                if($promotion->package_id !== $session->package_id && $promotion->package_id !== AllPackages::ALL){
                    return GlobalHelpers::formattedJSONResponse(Messages::PROMOTION_CODE_NOT_FOR_THIS_PACKAGE, null, null, Response::HTTP_BAD_REQUEST);
                }
                // and check the valid until date for the promotion
                if (Carbon::parse($promotion->valid_until, Values::DEFAULT_TIMEZONE)->gte(Carbon::now(Values::DEFAULT_TIMEZONE))) {
                    // calculate
                    $original_price = $session->total_price;
                    $offer = $promotion->offer;
                    $discount_amount = $original_price * ($offer / 100);
                    $total_price_after_discount = $original_price - $discount_amount;

                    // return response
                    return GlobalHelpers::formattedJSONResponse(Messages::PROMO_CODE_APPLIED, [
                        Attributes::ORIGINAL_PRICE => Helpers::formattedPrice($original_price),
                        Attributes::DISCOUNT_PRICE => Helpers::formattedPrice($discount_amount),
                        Attributes::TOTAL_PRICE => Helpers::formattedPrice($total_price_after_discount)
                    ], null, Response::HTTP_OK);

                } else {
                    return GlobalHelpers::formattedJSONResponse(Messages::PROMOTION_CODE_EXPIRED, null, null, Response::HTTP_BAD_REQUEST);
                }

            } else {
                return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
            }
        }
        return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Submit Feedback
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions/{id}/feedback",
     *     tags={"Metadata"},
     *     description="Submit Feedback",
     *     @OA\Response(response="200", description="Feedback submitted successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     * )
     */
    public function submitFeedback($id): JsonResponse
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

        $full_answer = null;

        $data = $this->request->all();
        foreach ($data as $item){

            $question_id = $item[Attributes::QUESTION_ID] ?? null;
            $answer = $item[Attributes::ANSWER] ?? null;

            if(!empty($question_id) && !empty($answer)){

                /** @var FeedbackQuestion $question */
                $question = FeedbackQuestion::find($question_id);
                if(!is_null($question)){

                    $full_answer = $full_answer . "- " . $question->question . "\n" . $answer . "\n\n";

                }

            }

        }

        // create feedback
        $feedback = Feedback::createOrUpdate([
            Attributes::USER_ID => $user->id,
            Attributes::FAMILY_ID => $user->family_id,
            Attributes::SESSION_ID => $session->id,
            Attributes::PACKAGE_ID => $session->package_id,
            Attributes::ANSWER => rtrim($full_answer),
        ],[
            Attributes::USER_ID, Attributes::SESSION_ID
        ]);

        // return response
        if (is_a($feedback, Feedback::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::FEEDBACK_SUBMITTED, [], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }


    /**
     * Confirm the session
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions/{id}/confirm",
     *     tags={"Sessions"},
     *     description="Confirm the session",
     *     @OA\Response(response="200", description="Session has been confirmed successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="promo_code", in="query", description="Promo Code", required=true, @OA\Schema(type="string")),
     * )
     */
    public function confirm($id): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // validate session
        /** @var Session $session */
        $session = Session::sessions()->where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->first();
        if (is_null($session)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SESSION, null, null, Response::HTTP_BAD_REQUEST);
        }

        // get parameters
        $promo_code = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PROMO_CODE, null, CastingTypes::STRING);



        if($session->status == SessionStatus::UNPAID){
            $session->status = SessionStatus::BOOKED;
            $save_session = $session->save();
            if($save_session){

                //get all sub_sessions and confirm them
                $sub_sessions = $session->subSessions()->get();
                foreach ($sub_sessions as $sub_session){
                    $sub_session->status = SessionStatus::BOOKED;
                    $save_sub_session = $sub_session->save();
                    if(!$save_sub_session){
                        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_UPDATE_STATUS, null, null, Response::HTTP_BAD_REQUEST);
                    }
                }

                //check promo code
                if(!is_null($promo_code)){
                    // get promotion
                    /** @var Promotion $promotion */
                    $promotion = Promotion::active()->where(Attributes::PROMO_CODE, $promo_code)->first();
                    if (!is_null($promotion)) {

                        if (Carbon::parse($promotion->valid_until, Values::DEFAULT_TIMEZONE)->gte(Carbon::now(Values::DEFAULT_TIMEZONE))) {

                            // create feedback
                            $promo_code_update = Promotion::createOrUpdate([
                                Attributes::USER_ID => $user->id,
                                Attributes::SESSION_ID => $session->id,
                                Attributes::STATUS => PromotionStatus::INACTIVE,
                                Attributes::PROMO_CODE => $promotion->promo_code
                            ],[
                                Attributes::USER_ID,
                                Attributes::PROMO_CODE,
                            ]);


                            if(!$promo_code_update){
                                return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROMOTION_CODE, null, null, Response::HTTP_BAD_REQUEST);
                            }
                        }
                    }

                }

                if (is_a($session, Session::class)) {
                    return GlobalHelpers::formattedJSONResponse(Messages::SESSION_CONFIRMED, [
                        Attributes::SESSIONS => Session::returnTransformedItems($session, ListSessionTransformer::class),
                    ], null, Response::HTTP_OK);
                }
            }
        }else{
            return GlobalHelpers::formattedJSONResponse(Messages::SESSION_ALREADY_CONFIRMED, null, null, Response::HTTP_BAD_REQUEST);
        }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }


    /**
     * Confirm the session
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions/{id}/reschedule",
     *     tags={"Sessions"},
     *     description="Confirm the session",
     *     @OA\Response(response="200", description="Session has been rescheduled successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="date", in="query", description="Date", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="time", in="query", description="time", required=true, @OA\Schema(type="string")),
     * )
     */
    public function reschedule($id): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get parameters
        $date = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DATE, null, CastingTypes::STRING);
        $time = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TIME, null, CastingTypes::STRING);

        if(empty($date) || empty($time)){
            return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PARAMETERS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // validate session
        /** @var Session $session */
        $session = Session::where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->first();
        if (is_null($session)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SESSION, null, null, Response::HTTP_BAD_REQUEST);
        }

        // update session
        $session->time = $time;
        $session->date = $date;
        $save_session = $session->save();

        if($save_session){
            if (is_a($session, Session::class)) {
                return GlobalHelpers::formattedJSONResponse(Messages::SESSION_CONFIRMED, [
                    Attributes::SESSIONS => Session::returnTransformedItems($session, ListSessionTransformer::class),
                ], null, Response::HTTP_OK);
            }
        }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }


    /**
     * Book Appointment
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/sessions/{id}/appointment",
     *     tags={"Sessions"},
     *     description="Book appointment for the  session",
     *     @OA\Response(response="200", description="Session has been rescheduled successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Session ID", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="date", in="query", description="Date", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="time", in="query", description="time", required=true, @OA\Schema(type="string")),
     * )
     */
    public function bookAppointment($id): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get parameters
        $date = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DATE, null, CastingTypes::STRING);
        $time = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TIME, null, CastingTypes::STRING);

        if(empty($date) || empty($time)){
            return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PARAMETERS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // validate session
        /** @var Session $session */
        $session = Session::where(Attributes::ID, $id)->where(Attributes::USER_ID, $user->id)->first();
        if (is_null($session)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_FIND_SESSION, null, null, Response::HTTP_BAD_REQUEST);
        }

       $save_appointment = Appointment::createOrUpdate([
        Attributes::USER_ID => $user->id,
        Attributes::SESSION_ID => $session->id,
        Attributes::DATE => $date,
        Attributes::TIME => $time,
    ],[
        Attributes::USER_ID,
        Attributes::SESSION_ID
       ]);

            if (is_a($session, Session::class) && $save_appointment) {
                return GlobalHelpers::formattedJSONResponse(Messages::SESSION_APPOINTMENT_BOOKED, [
                    Attributes::SESSIONS => Session::returnTransformedItems($session, ListSessionTransformer::class),
                ], null, Response::HTTP_OK);
            }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }

}
