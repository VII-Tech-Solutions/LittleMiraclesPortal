<?php

namespace App\API\Controllers;

use App\API\Requests\RegistrationRequest;
use App\API\Requests\SocialLoginRequest;
use App\Constants\Attributes;
use App\Constants\LoginProvider;
use App\Constants\Messages;
use App\Constants\Status;
use App\Helpers;
use App\Models\User;
use Exception;
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
    public function socialLogin(){

        // validate request
        $validation_response = GlobalHelpers::validateRequest(new SocialLoginRequest(), $this->request);
        if (GlobalHelpers::isValidObject($validation_response, JsonResponse::class)) {
            return $validation_response;
        }

        // validate provider
        $provider = trim(Str::lower(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PROVIDER, null, CastingTypes::STRING)));
        if(empty($provider) || !LoginProvider::hasValue($provider)){
            return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
        }

        $user = null;
        $username = null;
        $name = trim(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::NAME, null, CastingTypes::STRING));
        $provider_id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ID, null, CastingTypes::STRING);
        $email = Str::lower(trim(GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::EMAIL, null, CastingTypes::STRING)));
        if(empty($email)){
            $email = null;
        }

        // validate google login
        if($provider == LoginProvider::GOOGLE){

            // validate required fields
            if(!$this->request->has([Attributes::EMAIL, Attributes::ID, Attributes::PHOTO_URL, Attributes::NAME])){
                return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
            }

        }else if($provider == LoginProvider::FACEBOOK){

            // validate required fields
            if(!$this->request->has([Attributes::NAME])){
                return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);
            }

            $user = User::where(Attributes::PROVIDER_ID, $provider_id)->where(Attributes::PROVIDER, $provider)->first();

        }else if($provider == LoginProvider::SNAPCHAT) {

            // TODO Snapchat

        }else{
            return GlobalHelpers::formattedJSONResponse(__(Messages::BAD_REQUEST), null, null, Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        if(is_null($user) && !is_null($email)){
            $user = User::where(Attributes::EMAIL, $email)->first();
            if(!is_null($user) && $user->provider != $provider){
                return GlobalHelpers::formattedJSONResponse(__(Messages::INVALID_CREDENTIALS), null, null, Response::HTTP_BAD_REQUEST);
            }
        }


        // check if user exists
        try {
            if (is_null($user)) {

                // download avatar
                $avatar = $this->request->get(Attributes::PHOTO_URL) ?? null;
                if (!is_null($avatar) && Str::startsWith($avatar, "http")) {
                    $avatar = base64_encode(file_get_contents($avatar));
                }

                // create a user
                $user = User::createOrUpdate([
                    Attributes::EMAIL => $email,
                    Attributes::PROVIDER => $provider,
                    Attributes::PROVIDER_ID => $provider_id,
                    Attributes::STATUS => Status::ACTIVE,
                    Attributes::AVATAR => $avatar,
                    Attributes::USERNAME => $username
                ]);

            } else {

                // update avatar
                $avatar = $this->request->get(Attributes::PHOTO_URL) ?? null;
                if (!is_null($avatar) && Str::startsWith($avatar, "http")) {
                    $avatar = base64_encode(file_get_contents($avatar));
                    $user->avatar = $avatar;
                }

            }
        } catch (Exception $e) {
            Helpers::captureException($e);
        }

        // login as
        /** @var User $user */
        if(!is_null($user)){
            $user = Auth::loginUsingId($user->id);
        }

        // login and return response
        if(!is_null($user)){
            return $this->logMeIn($user);
        }
        return GlobalHelpers::formattedJSONResponse(Messages::BAD_REQUEST, null, null, Response::HTTP_BAD_REQUEST);

    }


    /**
     * Log Me In
     * @param User $user
     * @return JsonResponse
     */
    public function logMeIn($user)
    {

        $response = $user->createToken(Attributes::USER, []);

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



    }

}
