<?php

namespace App\API\Controllers;

use App\API\Transformers\ListPromotionTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\PromotionType;
use App\Constants\SessionStatus;
use App\Constants\Status;
use App\Helpers;
use App\Models\Package;
use App\Models\Promotion;
use App\Models\Session;
use Carbon\Carbon;
use Dingo\Api\Http\Response;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\GlobalHelpers;

/**
 * Gift Controller
 */
class GiftController extends CustomController
{

    /**
     * List All Gifts
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/gifts",
     *     tags={"Gifts"},
     *     description="List Gifts",
     *     @OA\Response(response="200", description="Gifts retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
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

        // get gifts
        $gifts = Promotion::where(Attributes::USER_ID, $user->id)->orderByDesc(Attributes::CREATED_AT)->get();

        // get last updated items
        if (!empty($this->last_update)) {
            $gifts = Helpers::getLatestOnlyInCollection($gifts, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::GIFTS => Promotion::returnTransformedItems($gifts, ListPromotionTransformer::class),
        ]);
    }

    /**
     * Claim Gift
     *
     * @return JsonResponse
     *
     * * @OA\POST(
     *     path="/api/gifts/claim",
     *     tags={"Gifts"},
     *     description="Claim Gift",
     *     @OA\Response(response="200", description="Gift claimed successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     */
    public function claim(): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get sessions
        /** @var Builder $session */
        $sessions = Session::where(Attributes::STATUS, SessionStatus::READY)
            ->where(Attributes::USER_ID, $user->id)
            ->where(Attributes::GIFT_CLAIMED, false)
            ->orderBy(Attributes::CREATED_AT);
        if($sessions->count() == 0){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // find package with gift
        /** @var Package $package */
        $package = Package::active()->where(Attributes::FIVE_SESSIONS_GIFT, true)->inRandomOrder()->first();
        if(is_null($package)){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // find a unique promo code for user
        $code = "123456789";
        $count = 0;
        do {
            $code = Helpers::generateCode();
            $existing_promotions = Promotion::active()->where(Attributes::PROMO_CODE, $code)->count();
            $count++;
        } while ($existing_promotions != 0 && $count == 10);

        // generate a gift promotion
        $gift = Promotion::createOrUpdate([
            Attributes::TITLE => null,
            Attributes::OFFER => 100,
            Attributes::TYPE => PromotionType::GIFT,
            Attributes::POSTED_AT => Carbon::now(),
            Attributes::VALID_UNTIL => Carbon::now()->addYear(),
            Attributes::CONTENT => null,
            Attributes::PROMO_CODE => $code,
            Attributes::IMAGE => $package->image,
            Attributes::STATUS => Status::ACTIVE,
            Attributes::USER_ID => $user->id,
            Attributes::PACKAGE_ID => $package->id,
        ], [
            Attributes::USER_ID, Attributes::PACKAGE_ID, Attributes::VALID_UNTIL
        ]);

        // validate the gift
        if(!is_a($gift, Promotion::class)){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // update all sessions
        $sessions->each(function($session){
            /** @var Session $session */
            $session->gift_claimed = true;
            $session->save();
        });

        // return response
        return GlobalHelpers::formattedJSONResponse(Messages::GIFT_CLAIMED, [
            Attributes::GIFTS => Promotion::returnTransformedItems(collect([$gift]), ListPromotionTransformer::class),
        ], null, Response::HTTP_OK);
    }

}
