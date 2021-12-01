<?php

namespace App\API\Controllers;

use App\API\Transformers\ListBackdropTransformer;
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
use App\Constants\Headers;
use App\Helpers;
use App\Models\Backdrop;
use App\Models\Cake;
use App\Models\DailyTip;
use App\Models\Faq;
use App\Models\Onboarding;
use App\Models\Page;
use App\Models\Photographer;
use App\Models\Promotion;
use App\Models\Section;
use App\Models\SessionPackage;
use App\Models\SocialMedia;
use App\Models\StudioMetadata;
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
        $packages = SessionPackage::active()->get();

        // get pages
        $pages = Page::active()->get();

        // TODO get user info
        // TODO fetch family if not null

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
            Attributes::PACKAGES => SessionPackage::returnTransformedItems($packages, ListPackageTransformer::class),
            Attributes::PAGES => Page::returnTransformedItems($pages, ListPageTransformer::class),
        ]);
    }

}
