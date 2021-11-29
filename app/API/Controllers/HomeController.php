<?php

namespace App\API\Controllers;

use App\API\Transformers\ListOnboardingTransformer;
use App\API\Transformers\ListPhotographerTransformer;
use App\Constants\Attributes;
use App\Constants\Status;
use App\Helpers;
use App\Models\Onboarding;
use App\Models\Photographer;
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
        // get on boardings
        $onboardings = Onboarding::where(Attributes::STATUS, Status::ACTIVE)->get()->sortBy(Attributes::ORDER);

        // get photographers
        $photographers = Photographer::where(Attributes::STATUS, Status::ACTIVE)->get()->sortBy(Attributes::ORDER);

        // return response
        return Helpers::returnResponse([
            Attributes::ONBOARDING => Onboarding::returnTransformedItems($onboardings, ListOnboardingTransformer::class),
            Attributes::PHOTOGRAPHERS => Photographer::returnTransformedItems($photographers, ListPhotographerTransformer::class)
        ]);
    }

}
