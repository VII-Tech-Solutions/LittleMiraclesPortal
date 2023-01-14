<?php

namespace App\API\Controllers;

use App\API\Requests\RegistrationRequest;
use App\API\Requests\SocialLoginRequest;
use App\Constants\Attributes;
use App\Constants\LoginProvider;
use App\Constants\Messages;
use App\Constants\Relationship;
use App\Constants\Status;
use App\Helpers;
use App\Models\FamilyInfo;
use App\Models\FamilyMember;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;
use VIITech\Helpers\Packagist\CarbonHelper;

/**
 * Authentication Controller
 */
class AuthenticationController extends CustomController
{

    /**
     * Social Login
     * @return JsonResponse
     */
    public function socialLogin()
    {

        // validate request
        $validation_response = GlobalHelpers::validateRequest(new SocialLoginRequest(), $this->request);
        if (GlobalHelpers::isValidObject($validation_response, JsonResponse::class)) {
            return $validation_response;
        }

        // validate provider
        $provider = trim(Str::lower(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PROVIDER, null, CastingTypes::STRING)));
        if (empty($provider) || !LoginProvider::hasValue($provider)) {
            return GlobalHelpers::formattedJSONResponse(Messages::INVALID_PROVIDER, null, null, Response::HTTP_BAD_REQUEST);
        }

        $user = null;
        $username = null;

        $name = trim(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::NAME, null, CastingTypes::STRING));
        $provider_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ID, null, CastingTypes::STRING);
        $email = Str::lower(trim(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::EMAIL, null, CastingTypes::STRING)));
        if (empty($email)) {
            $email = null;
        }

        // validate google login
        if ($provider == LoginProvider::GOOGLE) {

            // validate required fields
            if (!$this->request->has([Attributes::EMAIL, Attributes::ID, Attributes::PHOTO_URL, Attributes::NAME])) {
                return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
            }

        } else if ($provider == LoginProvider::FACEBOOK) {

            // validate required fields
            if (!$this->request->has([Attributes::NAME])) {
                return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
            }

            $user = User::where(Attributes::PROVIDER_ID, $provider_id)->where(Attributes::PROVIDER, $provider)->first();

        } else if ($provider == LoginProvider::SNAPCHAT) {
            // validate required fields
            if (!$this->request->has([Attributes::ID, Attributes::NAME])) {
                return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
            }

            $user = User::where(Attributes::PROVIDER_ID, $provider_id)->where(Attributes::PROVIDER, $provider)->first();

        } else if ($provider == LoginProvider::APPLE) {
            // validate required fields
            if (!$this->request->has([Attributes::EMAIL, Attributes::NAME])) {
                return GlobalHelpers::formattedJSONResponse(__(Messages::BAD_REQUEST), null, null, \Illuminate\Http\Response::HTTP_BAD_REQUEST);
            }
            $user = User::where(Attributes::PROVIDER_ID, $provider_id)->where(Attributes::PROVIDER, $provider)->first();

        } else {
            return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        if (is_null($user) && !is_null($email)) {
            $user = User::where(Attributes::EMAIL, $email)->where(Attributes::PROVIDER, $provider)->first();
//            if (!is_null($user) && $user->provider != $provider) {
//                return GlobalHelpers::formattedJSONResponse(Messages::INVALID_CREDENTIALS, null, null, Response::HTTP_BAD_REQUEST);
//            }
        }

        // get avatar
        $avatar = $this->request->get(Attributes::PHOTO_URL) ?? null;
        if (!is_null($avatar) && !Str::startsWith($avatar, "http")) {
            $avatar = base64_encode(file_get_contents($avatar));
        }

        // create a user
        if (is_null($user)) {
            $user = User::createOrUpdate([
                Attributes::EMAIL => $email,
                Attributes::PROVIDER => $provider,
                Attributes::PROVIDER_ID => $provider_id,
                Attributes::STATUS => Status::INCOMPLETE_PROFILE,
                Attributes::AVATAR => $avatar,
                Attributes::USERNAME => $username
            ], [
                Attributes::EMAIL,
                Attributes::PROVIDER,
                Attributes::PROVIDER_ID
            ]);
        } else {
            $user->avatar = $avatar;
            $user->save();
        }

        // login as
        /** @var User $user */
        if (!is_null($user)) {
            $user = Auth::loginUsingId($user->id);
        }

        // login and return response
        if (!is_null($user)) {
            return $this->logMeIn($user);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);

    }

    /**
     * Log Me In
     * @param User $user
     * @return JsonResponse
     */
    public function logMeIn($user)
    {

        $response = $user->createToken(Attributes::USER, []);

        // save token
        $this->saveToken($user);

        if (GlobalHelpers::isValidObject($response, PersonalAccessTokenResult::class)) {
            $response = $response->toArray();
            /** @var array $response */
            /** @var Token $token */
            $token = $response[Attributes::TOKEN];
            // return success message
            return GlobalHelpers::formattedJSONResponse(Messages::TOKEN_GENERATED, [
                Attributes::TYPE => "Bearer",
                Attributes::TOKEN => $response["accessToken"],
                Attributes::TIMESTAMP => CarbonHelper::getFormattedCarbonDateFromUTCDateTime($token->created_at),
                Attributes::EXPIRES => CarbonHelper::getFormattedCarbonDateFromUTCDateTime($token->expires_at),
                Attributes::USER => User::returnTransformedItems($user),
                Attributes::PARTNER => $user->myPartner() ? FamilyMember::returnTransformedItems($user->myPartner()) : null,
                Attributes::CHILDREN => FamilyMember::returnTransformedItems($user->myChildren()),
                Attributes::FAMILY_INFO => FamilyInfo::returnTransformedItems($user->myFamilyInfo()),
            ]);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::INVALID_CREDENTIALS, null, null, Response::HTTP_UNAUTHORIZED);
    }


    /**
     * Registration
     * @return JsonResponse
     */
    public function register()
    {

        // validate request
        $validation_response = GlobalHelpers::validateRequest(new RegistrationRequest(), $this->request);
        if (GlobalHelpers::isValidObject($validation_response, JsonResponse::class)) {
            return $validation_response;
        }

        // get current user info
        /** @var User $current_user */
        $current_user = Helpers::resolveUser();

        /** @var User $new_user */
        /** @var FamilyMember $new_partner */
        $new_user = null;
        $new_partner = null;
        $user_id = $current_user->id ?? null;
        $family_id = $current_user->family_id ?? Helpers::getNewFamilyID();

        // get parameters
        $user_info = $this->request->get(Attributes::USER);
        $partner_info = $this->request->get(Attributes::PARTNER);
        $children_info = $this->request->get(Attributes::CHILDREN);
        $family_info = $this->request->get(Attributes::FAMILY);

        // User
        if (!is_null($user_info)) {

            $user_info = collect($user_info);
            $fields = collect();

            Helpers::validateValueInCollection($user_info, $fields, Attributes::EMAIL);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::FIRST_NAME);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::LAST_NAME);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::GENDER);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::COUNTRY_CODE);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::PHONE_NUMBER);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::BIRTH_DATE);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::PAST_EXPERIENCE);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::PRO_PAST_EXPERIENCE);
            Helpers::validateValueInCollection($user_info, $fields, Attributes::HAPPY_PAST_EXPERIENCE);

            $fields->put(Attributes::ID, $user_id);
            $fields->put(Attributes::FAMILY_ID, $family_id);

            // create user
            $new_user = User::createOrUpdate($fields->toArray());

            $user_id = $new_user->id;
            $family_id = $new_user->family_id;
            $fields->put(Attributes::ID, $user_id);
            $fields->put(Attributes::FAMILY_ID, $family_id);
        }

        // Partner
        if (!is_null($partner_info) && is_a($new_user, User::class)) {

            $partner_info = collect($partner_info);
            $fields = collect();

            Helpers::validateValueInCollection($partner_info, $fields, Attributes::FIRST_NAME);
            Helpers::validateValueInCollection($partner_info, $fields, Attributes::LAST_NAME);
            Helpers::validateValueInCollection($partner_info, $fields, Attributes::GENDER);
            Helpers::validateValueInCollection($partner_info, $fields, Attributes::COUNTRY_CODE);
            Helpers::validateValueInCollection($partner_info, $fields, Attributes::PHONE_NUMBER);
            Helpers::validateValueInCollection($partner_info, $fields, Attributes::BIRTH_DATE);

            $fields->put(Attributes::RELATIONSHIP, Relationship::PARTNER);
            $fields->put(Attributes::USER_ID, $user_id);
            $fields->put(Attributes::FAMILY_ID, $family_id);

            $new_partner = FamilyMember::createOrUpdate($fields->toArray(), [
                Attributes::FAMILY_ID, Attributes::RELATIONSHIP
            ]);

        }

        // Children
        if (!is_null($children_info) && is_a($new_user, User::class) && is_a($new_partner, FamilyMember::class)) {

            $children_info = collect($children_info);
            $fields = collect();

            $fields->put(Attributes::RELATIONSHIP, Relationship::CHILDREN);
            $fields->put(Attributes::USER_ID, $user_id);
            $fields->put(Attributes::FAMILY_ID, $family_id);

            foreach ($children_info as $info) {
                $info = $fields->merge($info)->toArray();
                FamilyMember::createOrUpdate($info, [
                    Attributes::FAMILY_ID,
                    Attributes::RELATIONSHIP,
                    Attributes::FIRST_NAME,
                    Attributes::LAST_NAME,
                    Attributes::BIRTH_DATE
                ]);
            }
        }

        // Family Info
        if (!is_null($family_info) && is_a($new_user, User::class) && is_a($new_partner, FamilyMember::class)) {

            $family_info = collect($family_info);
            $fields = collect();

            $fields->put(Attributes::USER_ID, $user_id);
            $fields->put(Attributes::FAMILY_ID, $family_id);

            foreach ($family_info as $info) {
                $info = $fields->merge($info)->toArray();

                FamilyInfo::createOrUpdate($info, [
                    Attributes::FAMILY_ID,
                    Attributes::QUESTION_ID,
                ]);
            }
        }

        // change status
        if (!is_null($family_info) && is_a($new_user, User::class)) {
            $new_user->status = Status::ACTIVE;
            $new_user->save();
        }

        // save token
        if (!is_null($family_info) && is_a($new_user, User::class)) {
            $this->saveToken($new_user);
        }

        // return response
        if (is_a($new_user, User::class)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PROFILE_UPDATED, [
                Attributes::USER => User::returnTransformedItems($new_user),
                Attributes::PARTNER => $new_partner ? FamilyMember::returnTransformedItems($new_partner) : collect(),
                Attributes::CHILDREN => FamilyMember::returnTransformedItems($new_user->myChildren()),
                Attributes::FAMILY_INFO => FamilyInfo::returnTransformedItems($new_user->myFamilyInfo()),
            ], null, Response::HTTP_OK);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Save Token
     * @return void
     */
    function saveToken($user)
    {
        $token = trim(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::TOKEN, null, CastingTypes::STRING));
        $platform = trim(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PLATFORM, null, CastingTypes::STRING));
        if (empty($platform)) {
            $platform = $this->request->header(Attributes::PLATFORM);
        }
        if (!empty($token) && !empty($platform)) {
            UserToken::createOrUpdate([
                Attributes::USER_ID => $user->id,
                Attributes::TOKEN => $token,
                Attributes::PLATFORM => $platform
            ]);
        }
    }
}
