<?php

namespace App\API\Controllers;

use App\API\Transformers\ListOnboardingTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Models\Onboarding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use VIITech\Helpers\GlobalHelpers;

class OnboardingController extends CustomController
{
    /**
     * List On Boarding Screens
     *
     * @param Request $request
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/onboarding",
     *     tags={"Onboarding"},
     *     description="List All Onboarding",
     *     @OA\Response(response="200", description="List of Onboardings", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     */
    public function listAll(Request $request)
    {
        $onboardings = Onboarding::all()->sortBy(Attributes::ORDER);
        if (!GlobalHelpers::isValidObject($onboardings) || $onboardings->isEmpty()) {
            return GlobalHelpers::returnResponse(false, __(Messages::ITEM_NOT_FOUND), null, null, Response::HTTP_NOT_FOUND);
        }
        return GlobalHelpers::returnResponse(true, '', [
            Attributes::ONBOARDING => Onboarding::returnTransformedItems($onboardings, ListOnboardingTransformer::class)
        ]);
    }
}

