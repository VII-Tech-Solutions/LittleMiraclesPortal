<?php

namespace App\API\Controllers;

use App\API\Transformers\ListBackdropTransformer;
use App\API\Transformers\ListCakeTransformer;
use App\API\Transformers\ListDailyTipTransformer;
use App\API\Transformers\ListOnboardingTransformer;
use App\API\Transformers\ListPhotographerTransformer;
use App\API\Transformers\ListPromotionTransformer;
use App\API\Transformers\ListWorkshopTransformer;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Helpers;
use App\Models\Backdrop;
use App\Models\Cake;
use App\Models\DailyTip;
use App\Models\Onboarding;
use App\Models\Photographer;
use App\Models\Promotion;
use App\Models\Workshop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Home Controller
 */
class HomeController extends CustomController
{

    /**
     * App Data
     *
     * @param Request $request
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/data",
     *     tags={"Home"},
     *     description="App Data",
     *     @OA\Response(response="200", description="App Data", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     */
    public function data(Request $request)
    {

        // get current user info
        $user = Helpers::resolveUser();

        // TODO fetch family if not null

        // get on boardings
        $onboardings = Onboarding::where(Attributes::STATUS, Status::ACTIVE)->get()->sortBy(Attributes::ORDER);

        // get photographers
        $photographers = Photographer::where(Attributes::STATUS, Status::ACTIVE)->get();

        // get cakes
        $cakes = Cake::where(Attributes::STATUS, Status::ACTIVE)->get();

        // get backdrops
        $backdrops = Backdrop::where(Attributes::STATUS, Status::ACTIVE)->get();

        // get daily tips
        $daily_tips = DailyTip::where(Attributes::STATUS, Status::ACTIVE)->get();

        // get promotions
        $promotions = Promotion::where(Attributes::STATUS, Status::ACTIVE)->get();

        // Workshops List
        $workshops = Workshop::where(Attributes::STATUS, Status::ACTIVE)->get();

        // TODO Home Header
        // TODO Booking Section
        // TODO Packages List
        // TODO Studio Section
        // TODO User Info

        // return response
        return Helpers::returnResponse([
            Attributes::ONBOARDING => Onboarding::returnTransformedItems($onboardings, ListOnboardingTransformer::class),
            Attributes::PHOTOGRAPHERS => Photographer::returnTransformedItems($photographers, ListPhotographerTransformer::class),
            Attributes::CAKES => Cake::returnTransformedItems($cakes, ListCakeTransformer::class),
            Attributes::BACKDROPS => Backdrop::returnTransformedItems($backdrops, ListBackdropTransformer::class),
            Attributes::DAILY_TIPS => DailyTip::returnTransformedItems($daily_tips, ListDailyTipTransformer::class),
            Attributes::PROMOTIONS => Promotion::returnTransformedItems($promotions, ListPromotionTransformer::class),
            Attributes::WORKSHOPS => Workshop::returnTransformedItems($workshops, ListWorkshopTransformer::class),
        ]);
    }

}
