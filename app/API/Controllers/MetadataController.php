<?php

namespace App\API\Controllers;

use App\API\Transformers\FamilyInfoQuestionTransformer;
use App\API\Transformers\FeedbackQuestionTransformer;
use App\API\Transformers\ListReviewsTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\QuestionType;
use App\Helpers;
use App\Models\FamilyInfoQuestion;
use App\Models\Feedback;
use App\Models\FeedbackQuestion;
use App\Models\Review;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\GlobalHelpers;

/**
 * Metadata Controller
 */
class MetadataController extends CustomController
{

    /**
     * List All Family Info Questions
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/family-questions",
     *     tags={"Metadata"},
     *     description="Questions Metadata",
     *     @OA\Response(response="200", description="Questions retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function listAllFamilyInfoQuestions(): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get questions
        $questions = FamilyInfoQuestion::active()->get()->sortBy(Attributes::ORDER);

        // get last updated items
        if(!empty($this->last_update)){
            $questions = Helpers::getLatestOnlyInCollection($questions, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::QUESTIONS => FamilyInfoQuestion::returnTransformedItems($questions, FamilyInfoQuestionTransformer::class),
            Attributes::TYPES =>  QuestionType::toCustomArray(),
        ]);
    }

    /**
     * List All Feedback Questions
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/feedback-questions",
     *     tags={"Metadata"},
     *     description="Feedback Questions",
     *     @OA\Response(response="200", description="Questions retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function listAllFeedbackQuestions(): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get questions
        $questions = FeedbackQuestion::active()->get()->sortBy(Attributes::ID);

        // get last updated items
        if(!empty($this->last_update)){
            $questions = Helpers::getLatestOnlyInCollection($questions, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::QUESTIONS => FeedbackQuestion::returnTransformedItems($questions, FeedbackQuestionTransformer::class),
            Attributes::TYPES =>  QuestionType::toCustomArray(),
        ]);
    }
}
