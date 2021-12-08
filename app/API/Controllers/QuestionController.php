<?php

namespace App\API\Controllers;

use App\API\Transformers\FamilyInfoQuestionTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\QuestionType;
use App\Helpers;
use App\Models\FamilyInfoQuestion;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\GlobalHelpers;

/**
 * QuestionController Controller
 */
class QuestionController extends CustomController
{

    /**
     * User Registration
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/questions",
     *     tags={"Questions"},
     *     description="User Registration",
     *     @OA\Response(response="200", description="Questions retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    function listAll(): JsonResponse
    {

    // get current user info
        $user = Helpers::resolveUser();

            if (is_null($user)) {
                return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
            }

        // get questions
        $questions = FamilyInfoQuestion::active()->get()->sortBy(Attributes::ORDER);


        // get last updated items
        if(!is_null($this->last_update)){
            $questions = Helpers::getLatestOnlyInCollection($questions, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::QUESTIONS => FamilyInfoQuestion::returnTransformedItems($questions, FamilyInfoQuestionTransformer::class),
            Attributes::TYPES =>  QuestionType::toCustomArray(),
        ]);



    }

}
