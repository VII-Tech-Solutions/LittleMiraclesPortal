<?php

namespace App\API\Controllers;

use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListPromotionTransformer;
use App\Constants\Attributes;
use App\Constants\BookingType;
use App\Constants\GiftStatus;
use App\Constants\Messages;
use App\Constants\PromotionStatus;
use App\Constants\PromotionType;
use App\Constants\SessionStatus;
use App\Constants\Status;
use App\Constants\Values;
use App\Helpers\PaymentHelpers;
use App\Models\Helpers;
use App\Models\Order;
use App\Models\Package;
use App\Models\Promotion;
use App\Models\Session;
use App\Models\Transaction;
use Carbon\Carbon;
use Dingo\Api\Http\Response;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
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
        $gifts = Promotion::where(Attributes::USER_ID, $user->id)->with('package')->orderByDesc(Attributes::CREATED_AT)->get();

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
     *  Create Gift
     * @return JsonResponse
     */
    public function sendGift(): JsonResponse
    {
        // get current user
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get data
        $package_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PACKAGE_ID, null, CastingTypes::INTEGER);
        $to = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TO, null, CastingTypes::STRING);
        $from = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::FROM, null, CastingTypes::STRING);
        $message = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::MESSAGE, null, CastingTypes::STRING);

        // get package
        $package = Package::find($package_id);
        if (is_null($package)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PACKAGE_NOT_FOUND, null, null, Response::HTTP_NOT_FOUND);
        }

        // generate unique promo code for user
        $code = "123456789";
        $count = 0;
        do {
            $code = Helpers::generateCode();
            $existing_promotions = Promotion::where(Attributes::PROMO_CODE, $code)->count();
            $count++;
        } while ($existing_promotions != 0 && $count == 10);

        // create gift
        $gift = Promotion::createOrUpdate([
            Attributes::PACKAGE_ID => $package->id,
            Attributes::USER_ID => $user->id,
            Attributes::TO => $to,
            Attributes::FROM => $from,
            Attributes::MESSAGE => $message,
            Attributes::TYPE => PromotionType::GIFT,
            Attributes::PROMO_CODE => $code,
            Attributes::POSTED_AT => Carbon::now()->format('Y-m-d'),
            Attributes::AVAILABLE_FROM => Carbon::now()->format('Y-m-d'),
            Attributes::AVAILABLE_UNTIL => Carbon::now()->addYear()->format('Y-m-d'),
            Attributes::DAYS_OF_VALIDITY => 365,
            Attributes::VALID_UNTIL => Carbon::now()->addDays(365)->format('Y-m-d'),
            Attributes::STATUS => PromotionStatus::INACTIVE,
            Attributes::OFFER => 100
        ]);

        // validate the gift
        if (!is_a($gift, Promotion::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::GIFT => Promotion::returnTransformedItems($gift, ListPromotionTransformer::class),
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
            ->whereNull(Attributes::SESSION_ID)
            ->where(Attributes::USER_ID, $user->id)
            ->where(Attributes::GIFT_CLAIMED, false)
            ->orderBy(Attributes::CREATED_AT);

        if ($sessions->count() < 5) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // find package with gift
        /** @var Package $package_gift */
        $package = Promotion::active()->where(Attributes::STATUS, GiftStatus::ACTIVE)->whereNull(Attributes::USER_ID)
            ->whereDate(Attributes::AVAILABLE_FROM, '<=', Carbon::now()->format('Y-m-d'))
            ->whereDate(Attributes::AVAILABLE_UNTIL, '>=', Carbon::now()->format('Y-m-d'))->first();

        if (is_null($package)) {
            $package = Package::where(Attributes::TITLE, 'Mini Session')->first();
            if (is_null($package)) {
                return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
            } else {
                // if not found, then will need to generate mini session by default
                $package = Promotion::createOrUpdate([
                    Attributes::PACKAGE_ID => $package->id,
                    Attributes::IMAGE => $package->image,
                    Attributes::AVAILABLE_FROM => Carbon::now()->format('Y-m-d'),
                    Attributes::AVAILABLE_UNTIL => Carbon::now()->addMonths(6)->format('Y-m-d'),
                    Attributes::DAYS_OF_VALIDITY => 180,
                    Attributes::TYPE => PromotionType::GIFT
                ]);
            }
        }

        // find a unique promo code for user
        $code = "123456789";
        $count = 0;
        do {
            $code = Helpers::generateCode();
            $existing_promotions = Promotion::where(Attributes::PROMO_CODE, $code)->count();
            $count++;
        } while ($existing_promotions != 0 && $count == 10);

        // generate a gift promotion
        $gift = Promotion::createOrUpdate([
            Attributes::TITLE => null,
            Attributes::OFFER => 100,
            Attributes::TYPE => PromotionType::GIFT,
            Attributes::POSTED_AT => Carbon::now()->format('Y-m-d'),
            Attributes::VALID_UNTIL => Carbon::now()->addDays($package->days_of_validaty ?? 30)->format('Y-m-d'),
            Attributes::CONTENT => null,
            Attributes::PROMO_CODE => $code,
            Attributes::IMAGE => $package->image,
            Attributes::STATUS => Status::ACTIVE,
            Attributes::USER_ID => $user->id,
            Attributes::PACKAGE_ID => $package->id,
        ], [
            Attributes::USER_ID, Attributes::PACKAGE_ID, Attributes::VALID_UNTIL
        ]);
//
//        // validate the gift
        if (!is_a($gift, Promotion::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // update all sessions
        $sessions->each(function ($session) {
            /** @var Session $session */
            $session->gift_claimed = true;
            $session->save();

            //get all sub_sessions and confirm them
            $sub_sessions = $session->subSessions()->get();
            foreach ($sub_sessions as $sub_session) {
                $sub_session->gift_claimed = true;
                $save_sub_session = $sub_session->save();
            }

        });
        // return response
        return GlobalHelpers::formattedJSONResponse(Messages::GIFT_CLAIMED, [
            Attributes::GIFTS => Promotion::returnTransformedItems(collect([$gift]), ListPromotionTransformer::class),
        ], null, Response::HTTP_OK);
    }

    /**
     * Checkout Gift
     * @param $id
     * @return JsonResponse
     */
    public function checkout($id): JsonResponse
    {
        // get current user
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get payment method
        $payment_method = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PAYMENT_METHOD, null, CastingTypes::INTEGER);

        // get gift
        /** @var Promotion $gift */
        $gift = Promotion::find($id);
        if (is_null($gift)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // get package
        /** @var Package $package */
        $package = Package::find($gift->package_id);

        // calculate total
        $total = $package->price;
        $vat_amount = $total * Values::VAT_AMOUNT;
        $subtotal = $total + $vat_amount;

        // create order
        $order = Order::createOrUpdate([
            Attributes::USER_ID => $user->id,
            Attributes::TOTAL => $total,
            Attributes::SUBTOTAL => $subtotal,
            Attributes::VAT_AMOUNT => $vat_amount,
            Attributes::BOOKING_TYPE => BookingType::GIFT,
            Attributes::PROMO_ID => $gift->id,
        ], [
            Attributes::PROMO_ID
        ]);

        if (!is_a($order, Order::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        /** @var Transaction $transaction */
        list(Attributes::TRANSACTION => $transaction,
            Attributes::PAYMENT_URL => $payment_url) = PaymentHelpers::generatePaymentLink($order, $payment_method);

        // return response
        return Helpers::returnResponse([
            Attributes::PAYMENT_URL => $payment_url,
            Attributes::SUCCESS_INDICATOR => $transaction->success_indicator ?? null,
        ]);
    }
}
