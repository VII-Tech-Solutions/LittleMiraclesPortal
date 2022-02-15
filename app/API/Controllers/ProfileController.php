<?php

namespace App\API\Controllers;

use AnotherNamespace\Child;
use App\API\Requests\ProfileUpdateRequest;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Constants\Relationship;
use App\Helpers;
use App\Models\FamilyInfo;
use App\Models\FamilyMember;
use App\Models\User;
use Dingo\Api\Http\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

/**
 * Profile Controller
 */
class ProfileController extends CustomController
{

    /**
     * update profile
     *
     * @return JsonResponse
     *
     * * @OA\PUT(
     *     path="/api/profile",
     *     tags={"Users"},
     *     description="Profile Update",
     *     @OA\Response(response="200", description="User profile update successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     * @throws Exception
     */
    function update(): JsonResponse
    {
        /** @var User $user */
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // validate request
        $validation_response = GlobalHelpers::validateRequest(new ProfileUpdateRequest(), $this->request);
        if (GlobalHelpers::isValidObject($validation_response, JsonResponse::class)) {
            return $validation_response;
        }

        $is_partner = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::IS_PARTNER, null, CastingTypes::BOOLEAN);

        if($is_partner){
            $update_partner = FamilyMember::createOrUpdate([
                Attributes::ID => $user->myPartner()->id,
                Attributes::FIRST_NAME => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::FIRST_NAME, null, CastingTypes::STRING),
                Attributes::LAST_NAME => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::LAST_NAME, null, CastingTypes::STRING),
                Attributes::GENDER => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::GENDER, null, CastingTypes::INTEGER),
                Attributes::COUNTRY_CODE => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COUNTRY_CODE, null, CastingTypes::STRING),
                Attributes::PHONE_NUMBER => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PHONE_NUMBER, null, CastingTypes::STRING),
                Attributes::BIRTH_DATE => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::BIRTH_DATE, null, CastingTypes::STRING),
                Attributes::RELATIONSHIP => Relationship::PARTNER

            ],[
                Attributes::ID
            ]);


            if($update_partner){
                return GlobalHelpers::formattedJSONResponse(Messages::PARTNER_UPDATE_REQUESTED, [
                    Attributes::PARTNER =>  FamilyMember::returnTransformedItems($update_partner)
                ], null, Response::HTTP_OK);
            }

        }else{
            $update_user = User::createOrUpdate([
                Attributes::ID => $user->id,
                Attributes::FIRST_NAME => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::FIRST_NAME, null, CastingTypes::STRING),
                Attributes::LAST_NAME => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::LAST_NAME, null, CastingTypes::STRING),
                Attributes::GENDER => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::GENDER, null, CastingTypes::INTEGER),
                Attributes::COUNTRY_CODE => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::COUNTRY_CODE, null, CastingTypes::STRING),
                Attributes::PHONE_NUMBER => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PHONE_NUMBER, null, CastingTypes::STRING),
                Attributes::BIRTH_DATE => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::BIRTH_DATE, null, CastingTypes::STRING)

            ],[
                Attributes::ID
            ]);

            if($update_user){
                return GlobalHelpers::formattedJSONResponse(Messages::PROFILE_UPDATE_REQUESTED, [
                    Attributes::USER =>  User::returnTransformedItems($update_user)
                ], null, Response::HTTP_OK);
            }

        }

        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS,[], null, Response::HTTP_BAD_REQUEST);

    }


    /**
     * update partner
     *
     * @return JsonResponse
     *
     * * @OA\PUT(
     *     path="/api/partner",
     *     tags={"Users"},
     *     description="Profile Update",
     *     @OA\Response(response="200", description="User profile update successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     * @throws Exception
     */
    function updatePartner(): JsonResponse
    {
        /** @var User $user */
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // validate request
        $validation_response = GlobalHelpers::validateRequest(new ProfileUpdateRequest(), $this->request);
        if (GlobalHelpers::isValidObject($validation_response, JsonResponse::class)) {
            return $validation_response;
        }

        // merge user id
        $this->request->merge([
            Attributes::IS_PARTNER => true,
        ]);

        return $this->updateProfile();
    }


    /**
     * update children
     *
     * @return JsonResponse
     *
     * * @OA\PUT(
     *     path="/api/children",
     *     tags={"Users"},
     *     description="Children Update",
     *     @OA\Response(response="200", description="User profile update successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     * @throws Exception
     */
    function updateChildren(): JsonResponse
    {
        /** @var User $user */
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        $children =  json_decode($this->request->getContent(), true);

        if(empty($children)){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS,[], null, Response::HTTP_BAD_REQUEST);
        }

        // soft delete all children
        $user->myChildrenQuery()->delete();
        foreach ($children as $child){
            $new_child = FamilyMember::createOrUpdate([
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::FIRST_NAME => $child["first_name"] ?? null,
                Attributes::LAST_NAME => $child["last_name"] ?? null,
                Attributes::GENDER => $child["gender"] ?? null,
                Attributes::BIRTH_DATE => $child["birth_date"] ?? null,
                Attributes::PERSONALITY => $child["personality"] ?? null,
                Attributes::RELATIONSHIP => Relationship::CHILDREN
            ],
            [
                Attributes::USER_ID,
                Attributes::FAMILY_ID,
                Attributes::FIRST_NAME,
                Attributes::LAST_NAME,
            ]);
        }

        // return response
            return GlobalHelpers::formattedJSONResponse(Messages::PROFILE_UPDATED, [
                Attributes::CHILDREN => FamilyMember::returnTransformedItems($user->myChildren()),
            ], null, \Illuminate\Http\Response::HTTP_OK);

    }


    /**
     * update family
     *
     * @return JsonResponse
     *
     * * @OA\PUT(
     *     path="/api/family",
     *     tags={"Users"},
     *     description="Family Update",
     *     @OA\Response(response="200", description="User profile update successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     * )
     * @throws Exception
     */
    function updateFamily(): JsonResponse
    {
        /** @var User $user */
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        $family =  json_decode($this->request->getContent(), true);

        if(empty($family)){
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS,[], null, Response::HTTP_BAD_REQUEST);
        }

        // soft delete all children
        $user->myFamilyInfoQuery()->delete();
        foreach ($family as $info){
            $new_info = FamilyInfo::createOrUpdate([
                Attributes::USER_ID => $user->id,
                Attributes::FAMILY_ID => $user->family_id,
                Attributes::QUESTION_ID => $info["question_id"] ?? null,
                Attributes::ANSWER => $info["answer"] ?? null
            ],
                [
                    Attributes::USER_ID,
                    Attributes::FAMILY_ID,
                    Attributes::QUESTION_ID,
                    Attributes::ANSWER,
                ]);
        }

        // return response
        return GlobalHelpers::formattedJSONResponse(Messages::FAMILY_INFO_UPDATE_REQUESTED, [
            Attributes::FAMILY => FamilyInfo::returnTransformedItems($user->myFamilyInfo()),
        ], null, \Illuminate\Http\Response::HTTP_OK);

    }

}
