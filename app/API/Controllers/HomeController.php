<?php

namespace App\API\Controllers;

use App\API\Transformers\AvailableDateTransformer;
use App\API\Transformers\AvailableHourTransformer;
use App\API\Transformers\ListBackdropCategoryTransformer;
use App\API\Transformers\ListBackdropTransformer;
use App\API\Transformers\ListCakeCategoryTransformer;
use App\API\Transformers\ListCakeTransformer;
use App\API\Transformers\ListDailyTipTransformer;
use App\API\Transformers\ListFAQsTransformer;
use App\API\Transformers\ListOnboardingTransformer;
use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListPageTransformer;
use App\API\Transformers\ListPhotographerTransformer;
use App\API\Transformers\ListPromotionTransformer;
use App\API\Transformers\ListSectionTransformer;
use App\API\Transformers\ListSocialMediaTransformer;
use App\API\Transformers\ListStudioMetadataTransformer;
use App\API\Transformers\ListWorkshopTransformer;
use App\Constants\Attributes;
use App\Constants\AvailableDateType;
use App\Constants\Headers;
use App\Constants\PaymentMethod;
use App\Helpers;
use App\Models\AvailableDate;
use App\Models\Backdrop;
use App\Models\BackdropCategory;
use App\Models\Cake;
use App\Models\CakeCategory;
use App\Models\DailyTip;
use App\Models\Faq;
use App\Models\Onboarding;
use App\Models\Page;
use App\Models\Photographer;
use App\Models\Promotion;
use App\Models\Section;
use App\Models\Package;
use App\Models\SocialMedia;
use App\Models\StudioMetadata;
use App\Models\UserDevice;
use App\Models\Workshop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

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
     * Email
     * @return View
     */
    function email(){
        return view('emails.invoice');
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

        // get faq
        $faqs = Faq::active()->get();

        // get studio metadata
        $studio_metadata = StudioMetadata::active()->get();

        //  get social media
        $social = SocialMedia::active()->get();

        // get packages
        $packages = Package::active()->get();

        // get pages
        $pages = Page::active()->get();

        // get payment methods
        $payment_methods = PaymentMethod::readableArray();

        // fetch backdrop categories
        $backdrop_categories = $backdrops->map->category;
        $backdrop_categories = $backdrop_categories->flatten()->filter()->unique(Attributes::ID);

        // fetch cake categories
        $cake_categories = $cakes->map->category;
        $cake_categories = $cake_categories->flatten()->filter()->unique(Attributes::ID);;

        // get last updated items
        if(!is_null($this->last_update)){
            $onboardings = Helpers::getLatestOnlyInCollection($onboardings, $this->last_update);
            $photographers = Helpers::getLatestOnlyInCollection($photographers, $this->last_update);
            $cakes = Helpers::getLatestOnlyInCollection($cakes, $this->last_update);
            $backdrops = Helpers::getLatestOnlyInCollection($backdrops, $this->last_update);
            $daily_tips = Helpers::getLatestOnlyInCollection($daily_tips, $this->last_update);
            $promotions = Helpers::getLatestOnlyInCollection($promotions, $this->last_update);
            $workshops = Helpers::getLatestOnlyInCollection($workshops, $this->last_update);
            $sections = Helpers::getLatestOnlyInCollection($sections, $this->last_update);
            $faqs = Helpers::getLatestOnlyInCollection($faqs, $this->last_update);
            $studio_metadata = Helpers::getLatestOnlyInCollection($studio_metadata, $this->last_update);
            $social = Helpers::getLatestOnlyInCollection($social, $this->last_update);
            $packages = Helpers::getLatestOnlyInCollection($packages, $this->last_update);
            $pages = Helpers::getLatestOnlyInCollection($pages, $this->last_update);
            $backdrop_categories = Helpers::getLatestOnlyInCollection($backdrop_categories, $this->last_update);
            $cake_categories = Helpers::getLatestOnlyInCollection($cake_categories, $this->last_update);
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
            Attributes::FAQS => Faq::returnTransformedItems($faqs, ListFAQsTransformer::class),
            Attributes::STUDIO_METADATA => StudioMetadata::returnTransformedItems($studio_metadata, ListStudioMetadataTransformer::class),
            Attributes::SOCIAL_MEDIA => SocialMedia::returnTransformedItems($social, ListSocialMediaTransformer::class),
            Attributes::PACKAGES => Package::returnTransformedItems($packages, ListPackageTransformer::class),
            Attributes::PAGES => Page::returnTransformedItems($pages, ListPageTransformer::class),
            Attributes::PAYMENT_METHODS => $payment_methods,
            Attributes::BACKDROP_CATEGORIES => BackdropCategory::returnTransformedItems($backdrop_categories, ListBackdropCategoryTransformer::class),
            Attributes::CAKE_CATEGORIES => CakeCategory::returnTransformedItems($cake_categories, ListCakeCategoryTransformer::class),
        ]);
    }

    /**
     * List All Available Hours
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/available-hours",
     *     tags={"Home"},
     *     description="List of Available Hours",
     *     @OA\Response(response="200", description="Available hours retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="date", in="query", description="Date: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function availableHours(): JsonResponse
    {

        // get parameters
        $date = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::DATE, null, CastingTypes::STRING);

        // build available dates query
        $available_dates = AvailableDate::active()->where(Attributes::TYPE, AvailableDateType::INCLUDE);

        // filter by date
        if(!empty($date)){
            $available_dates = $available_dates->where(Attributes::START_DATE, $date);
        }

        // TODO exclude by type

        // TODO exclude if booked

        // get available dates
        $available_dates = $available_dates->get();

        // filter by last update
        if(!is_null($this->last_update)) {
            $available_dates = Helpers::getLatestOnlyInCollection($available_dates, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::DATES => AvailableDate::returnTransformedItems($available_dates, AvailableDateTransformer::class),
        ]);
    }

}
