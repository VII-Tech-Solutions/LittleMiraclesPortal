<?php

namespace App\API\Controllers;

use App\API\Transformers\AvailableDateTransformer;
use App\API\Transformers\ListBackdropCategoryTransformer;
use App\API\Transformers\ListBackdropTransformer;
use App\API\Transformers\ListCakeCategoryTransformer;
use App\API\Transformers\ListCakeTransformer;
use App\API\Transformers\ListDailyTipTransformer;
use App\API\Transformers\ListFAQsTransformer;
use App\API\Transformers\ListNotificationsTransformer;
use App\API\Transformers\ListOnboardingTransformer;
use App\API\Transformers\ListPackagePhotographersTransformer;
use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListPageTransformer;
use App\API\Transformers\ListPhotographerTransformer;
use App\API\Transformers\ListPromotionTransformer;
use App\API\Transformers\ListSectionTransformer;
use App\API\Transformers\ListSocialMediaTransformer;
use App\API\Transformers\ListStudioMetadataTransformer;
use App\API\Transformers\ListStudioPackageTransformer;
use App\API\Transformers\ListWorkshopTransformer;
use App\Constants\Attributes;
use App\Constants\AvailableDateType;
use App\Constants\Headers;
use App\Constants\Messages;
use App\Constants\NotificationType;
use App\Constants\PaymentMethods;
use App\Constants\PromotionType;
use App\Constants\Values;
use App\Models\AvailableDate;
use App\Models\Backdrop;
use App\Models\BackdropCategory;
use App\Models\Cake;
use App\Models\CakeCategory;
use App\Models\DailyTip;
use App\Models\Faq;
use App\Models\Helpers;
use App\Models\Notification;
use App\Models\Onboarding;
use App\Models\Package;
use App\Models\PackagePhotographer;
use App\Models\Page;
use App\Models\Photographer;
use App\Models\Promotion;
use App\Models\Section;
use App\Models\Session;
use App\Models\SocialMedia;
use App\Models\StudioMetadata;
use App\Models\StudioPackage;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserToken;
use App\Models\Workshop;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
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
    function welcome()
    {
        return view('welcome');
    }

    /**
     * Home
     * @return RedirectResponse
     */
    function home()
    {
        return redirect(backpack_url());
    }

    /**
     * Email
     * @return View
     */
    function email()
    {
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
        if (!is_null($user)) {
            UserDevice::createOrUpdate([
                Attributes::USER_ID => $user->id,
                Attributes::PLATFORM => $this->request->hasHeader(Headers::PLATFORM) ? $this->request->header(Headers::PLATFORM) : $this->request->get(Headers::PLATFORM),
                Attributes::APP_VERSION => $this->request->hasHeader(Headers::APP_VERSION) ? $this->request->header(Headers::APP_VERSION) : $this->request->get(Headers::APP_VERSION),
                Attributes::TOKEN => $this->request->get(Attributes::TOKEN),
            ], [
                Attributes::USER_ID, Attributes::PLATFORM
            ]);
        }

        // get on boardings
        $onboardings = Onboarding::withTrashed()->active()->get()->sortBy(Attributes::ORDER);

        // get photographers
        $photographers = Photographer::withTrashed()->active()->orderBy(Attributes::PRIORITY)->get();

        // get cakes
        $cakes = Cake::withTrashed()->active()->get();

        // get backdrops
        $backdrops = Backdrop::withTrashed()->active()->get();

        // get daily tips
        $daily_tips = DailyTip::withTrashed()->active()->get();

        // get promotions
        $promotions = Promotion::withTrashed()->active()->where(Attributes::TYPE, PromotionType::PUBLIC)->get();

        // get workshops
        $workshops = Workshop::withTrashed()->active()->get();

        // get home header
        $sections = Section::withTrashed()->active()->get();

        // get faq
        $faqs = Faq::withTrashed()->active()->get();

        // get studio metadata
        $studio_metadata = StudioMetadata::withTrashed()->active()->get();

        //  get social media
        $social = SocialMedia::withTrashed()->active()->get();

        // get packages
        $packages = Package::withTrashed()->active()->get();

        // get package photographers
        $package_photographers = PackagePhotographer::withTrashed()->active()->get();

        // get pages
        $pages = Page::withTrashed()->active()->get();

        // studio packages
        $studio_packages = StudioPackage::withTrashed()->active()->get();

        // get payment methods
        $payment_methods = PaymentMethods::readableArray();

        // fetch backdrop categories
        $backdrop_categories = $backdrops->map->category;
        $backdrop_categories = $backdrop_categories->flatten()->filter()->unique(Attributes::ID);

        // fetch cake categories
        $cake_categories = CakeCategory::withTrashed()->active()->get();

        // get notifications
        $notifications = Notification::withTrashed()->active()->get();

        // get last updated items
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
        $package_photographers = Helpers::getLatestOnlyInCollection($package_photographers, $this->last_update);
        $pages = Helpers::getLatestOnlyInCollection($pages, $this->last_update);
        $backdrop_categories = Helpers::getLatestOnlyInCollection($backdrop_categories, $this->last_update);
        $cake_categories = Helpers::getLatestOnlyInCollection($cake_categories, $this->last_update);
        $studio_packages = Helpers::getLatestOnlyInCollection($studio_packages, $this->last_update);
        $notifications = Helpers::getLatestOnlyInCollection($notifications, $this->last_update);

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
            Attributes::PACKAGE_PHOTOGRAPHERS => PackagePhotographer::returnTransformedItems($package_photographers, ListPackagePhotographersTransformer::class),
            Attributes::PAGES => Page::returnTransformedItems($pages, ListPageTransformer::class),
            Attributes::PAYMENT_METHODS => $payment_methods,
            Attributes::BACKDROP_CATEGORIES => BackdropCategory::returnTransformedItems($backdrop_categories, ListBackdropCategoryTransformer::class),
            Attributes::CAKE_CATEGORIES => CakeCategory::returnTransformedItems($cake_categories, ListCakeCategoryTransformer::class),
            Attributes::STUDIO_PACKAGES => StudioPackage::returnTransformedItems($studio_packages, ListStudioPackageTransformer::class),
            Attributes::NOTIFICATIONS => Notification::returnTransformedItems($notifications, ListNotificationsTransformer::class)
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
        $photographer_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PHOTOGRAPHER_ID, null, CastingTypes::INTEGER);
        /** @var User $user */
        $user = Helpers::resolveUser();

        // build available dates query
        $available_dates = AvailableDate::active()->where(Attributes::TYPE, AvailableDateType::INCLUDE)->where(Attributes::PHOTOGRAPHER_ID, $photographer_id);

        // filter by date
        if (!empty($date)) {
            $available_dates = $available_dates->where(Attributes::START_DATE, $date);
        }


        // TODO exclude by type

        // get available dates
        $available_dates = $available_dates->get();

        // filter by last update
        if (!is_null($this->last_update)) {
            $available_dates = Helpers::getLatestOnlyInCollection($available_dates, $this->last_update);
        }

        $available_dates_collection = collect();

        $available_dates->each(function ($item) use (&$available_dates_collection, $photographer_id, $user) {

            /** @var AvailableDate $item */
            $start_date = $item->start_date;
            $end_date = $item->end_date;
            $hours = $item->hours;

            $count = 0;
            $date_range = CarbonPeriod::create($start_date, $end_date)->setTimezone(Values::DEFAULT_TIMEZONE);

            foreach ($date_range as $date) {
                /** @var $date Carbon */

                $timings_collection = collect();

                $day_of_week = $date->dayOfWeek;
                if ($day_of_week < 6) {
                    $day_of_week += 1;
                } else {
                    $day_of_week = 0;
                }

                $timings = $hours->where(Attributes::DAY_ID, $day_of_week);

                if ($timings->isNotEmpty()) {

                    foreach ($timings as $time) {

                        $interval = CarbonPeriod::since($time->from)->hours(1)->until($time->to)->toArray();

                        foreach ($interval as $time_from_to) {
                            $formatted_date = $time_from_to->format(Values::CARBON_HOUR_FORMAT);
                            $formatted_24_date = $time_from_to->format(Values::CARBON_24_HOUR_FORMAT);

                            $photographer_session = Session::paid()/*where(Attributes::PHOTOGRAPHER, $photographer_id)*/->where(Attributes::DATE, $date->format(Values::CARBON_DATE_FORMAT))
                                ->where(Attributes::TIME, $formatted_date)
                                ->first();
                            if (!is_null($user)) {
                                $user_session = Session::where(Attributes::USER_ID, $user->id)
                                    ->where(Attributes::DATE, $date->format(Values::CARBON_DATE_FORMAT))
                                    ->where(Attributes::TIME, $formatted_date)
                                    ->first();
                            }
                            if (is_null($photographer_session) && !isset($user_session)) {
                                $timings_collection->add($time_from_to->format(Values::CARBON_HOUR_FORMAT));
                            }
                        }

                        $this_date = Carbon::parse($start_date, Values::DEFAULT_TIMEZONE)->addDays($count);

                        if ($this_date->isPast()) {
                            continue;
                        }

                        $item[Attributes::TIMINGS] = $timings_collection->toArray();
                        $item[Attributes::DATE] = $this_date->format(Values::CARBON_DATE_FORMAT);
                        $available_dates_collection->add($item->toArray());

                    }

                }

                $count++;

            }
        });

        // return response
        return Helpers::returnResponse([
            Attributes::DATES => AvailableDate::returnTransformedItems($available_dates_collection, AvailableDateTransformer::class),
        ]);
    }


    function test()
    {
        $unselected_color = '#d0d3d6';
        $selected_color = '#bbdce0';
        $border_width = 5;
        $border_colour = $selected_color;

//        $selected_background = Image::canvas(500, 500, '#bbdce0');
        $unselected_background = Image::canvas(500, 500, $unselected_color);
//        $unselected_background->resizeCanvas($border_width*2, $border_width*3, 'center', true, $selected_color);
//
//        $unselected_background = Image::make("images/test.png");
//        $img = Image::make('public/foo.jpg');
        $img = Image::make($unselected_background)->resize(800, 1200);

        return $img->response('png');

    }

    /**
     * Send Chat Message
     * @return JsonResponse
     * @OA\GET(
     *     path="/chat",
     *     tags={"Chat"},
     *     description="Send Message",
     *     @OA\Response(response="200", description="Send Chat Message", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="401", description="Permission denied", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="Authorization", in="header", description="Authorization", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="title", in="query", description="Title", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="message", in="query", description="Message", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="environment", in="query", description="Environment", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="topic", in="query", description="Topic", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="room_id", in="query", description="Room ID", required=true, @OA\Schema(type="string")),
     * )
     */
    function chatMessage()
    {

        /** @var User $user */
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get variables
        $title = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TITLE, null, CastingTypes::STRING);
        $message = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::MESSAGE, null, CastingTypes::STRING);
        $environment = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ENVIRONMENT, null, CastingTypes::STRING);
        $room_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ROOM_ID, null, CastingTypes::STRING);
        $family_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::FAMILY_ID, null, CastingTypes::STRING);
        $topic = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TOPIC, null, CastingTypes::STRING);
        $user_id = str_replace("user_", "", $topic);
        $is_photographer = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::IS_PHOTOGRAPHER, false, CastingTypes::BOOLEAN);

        // send fcm
        $sent = UserToken::sendFCMByToken($user_id, $environment, $is_photographer, [
            Attributes::TITLE => $title,
            Attributes::MESSAGE => $message,
            Attributes::TYPE => NotificationType::CHAT,
            Attributes::ROOM_ID => $room_id,
            Attributes::USER_ID => $user_id,
            Attributes::FAMILY_ID => $family_id,
        ], false);

        // return response
        if ($sent) {
            return GlobalHelpers::formattedJSONResponse(Messages::MESSAGE_SENT, null, null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }
}
