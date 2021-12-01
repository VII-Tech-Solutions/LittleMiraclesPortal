<?php

namespace App\API\Controllers;

use App\API\Transformers\ListBackdropTransformer;
use App\API\Transformers\ListCakeTransformer;
use App\API\Transformers\ListDailyTipTransformer;
use App\API\Transformers\ListOnboardingTransformer;
use App\API\Transformers\ListPhotographerTransformer;
use App\API\Transformers\ListPromotionTransformer;
use App\API\Transformers\ListSectionTransformer;
use App\API\Transformers\ListWorkshopTransformer;
use App\Constants\Attributes;
use App\Constants\Headers;
use App\Helpers;
use App\Models\Backdrop;
use App\Models\Cake;
use App\Models\DailyTip;
use App\Models\Onboarding;
use App\Models\Photographer;
use App\Models\Promotion;
use App\Models\Section;
use App\Models\UserDevice;
use App\Models\Workshop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Home Controller
 */
class HomeController extends CustomController
{

    /**
     * Welcome
     * @return View
     */
    function welcome(){
        return view('welcome');
    }

    /**
     * Home
     * @return RedirectResponse
     */
    function home(){
        return redirect(backpack_url());
    }

    /**
     * App Data
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/data",
     *     tags={"Home"},
     *     description="App Data",
     *     @OA\Response(response="200", description="App Data", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function data()
    {

        // get current user info
        $user = Helpers::resolveUser();

        // TODO fetch family if not null

        // update user device
        if(!is_null($user)){
            UserDevice::createOrUpdate([
                Attributes::USER_ID => $user->id,
                Attributes::PLATFORM =>  $this->request->hasHeader(Headers::PLATFORM) ? $this->request->header(Headers::PLATFORM) : $this->request->get(Headers::PLATFORM),
                Attributes::APP_VERSION =>  $this->request->hasHeader(Headers::APP_VERSION) ? $this->request->header(Headers::APP_VERSION) : $this->request->get(Headers::APP_VERSION),
                Attributes::TOKEN =>  $this->request->get(Attributes::TOKEN),
            ],[
                Attributes::USER_ID, Attributes::PLATFORM
            ]);
        }

        // get on boardings
        $onboardings = Onboarding::active()->get()->sortBy(Attributes::ORDER);

        // get photographers
        $photographers = Photographer::active()->get();

        // get cakes
        $cakes = Cake::active()->get();

        // get backdrops
        $backdrops = Backdrop::active()->get();

        // get daily tips
        $daily_tips = DailyTip::active()->get();

        // get promotions
        $promotions = Promotion::active()->get();

        // get workshops
        $workshops = Workshop::active()->get();

        // get home header
        $sections = Section::active()->get();

        // TODO get packages
        // TODO get studio metadata
        // TODO User Info

        // get last updated items
        if(!is_null($this->last_update)){
            $onboardings = Helpers::getLatestOnlyInCollection($onboardings, $this->last_update);
            $photographers = Helpers::getLatestOnlyInCollection($photographers, $this->last_update);
            $cakes = Helpers::getLatestOnlyInCollection($cakes, $this->last_update);
            $backdrops = Helpers::getLatestOnlyInCollection($backdrops, $this->last_update);
            $daily_tips = Helpers::getLatestOnlyInCollection($daily_tips, $this->last_update);
            $promotions = Helpers::getLatestOnlyInCollection($promotions, $this->last_update);
            $workshops = Helpers::getLatestOnlyInCollection($workshops, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::ONBOARDING => Onboarding::returnTransformedItems($onboardings, ListOnboardingTransformer::class),
            Attributes::PHOTOGRAPHERS => Photographer::returnTransformedItems($photographers, ListPhotographerTransformer::class),
            Attributes::CAKES => Cake::returnTransformedItems($cakes, ListCakeTransformer::class),
            Attributes::BACKDROPS => Backdrop::returnTransformedItems($backdrops, ListBackdropTransformer::class),
            Attributes::DAILY_TIPS => DailyTip::returnTransformedItems($daily_tips, ListDailyTipTransformer::class),
            Attributes::PROMOTIONS => Promotion::returnTransformedItems($promotions, ListPromotionTransformer::class),
            Attributes::WORKSHOPS => Workshop::returnTransformedItems($workshops, ListWorkshopTransformer::class),
            Attributes::SECTIONS => Section::returnTransformedItems($sections, ListSectionTransformer::class),
        ]);
    }

}
