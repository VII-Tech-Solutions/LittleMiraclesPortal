<?php

namespace App\API\Controllers;

use App\API\Requests\ProfileUpdateRequest;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Helpers;
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
     *     path="/api/users/profile",
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
                Attributes::BIRTH_DATE => GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::BIRTH_DATE, null, CastingTypes::STRING)

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
     *     path="/api/users/partner",
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


}
