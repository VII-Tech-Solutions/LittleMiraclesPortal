<?php

namespace App\API\Controllers;

use App\API\Requests\PhotographerLoginRequest;
use App\API\Transformers\ListPhotographerTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Models\FamilyInfo;
use App\Models\FamilyMember;
use App\Models\Helpers;
use App\Models\Photographer;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;
use VIITech\Helpers\Packagist\CarbonHelper;

class PhotographerController extends CustomController
{

    /**
     * Login
     * @return bool|JsonResponse
     */
    public function login()
    {

        // validate request
        $validation_response = GlobalHelpers::validateRequest(new PhotographerLoginRequest(), $this->request);
        if (GlobalHelpers::isValidObject($validation_response, JsonResponse::class)) {
            return $validation_response;
        }
        $email = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::EMAIL, null, CastingTypes::STRING);
        $password = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::PASSWORD, null, CastingTypes::STRING);


        if (Auth::guard('api_photographers')->attempt($this->request->only(Attributes::EMAIL, Attributes::PASSWORD))) {
            $email = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::EMAIL, null, CastingTypes::STRING);

            $photographer = Photographer::where(Attributes::EMAIL, $email)->first();

            if (!is_null($photographer)) {
                $photographer = Auth::guard('api_photographers')->loginUsingId($photographer->id);;
                return $this->logMeIn($photographer);
            }
        }

        return GlobalHelpers::formattedJSONResponse(__(Messages::INVALID_CREDENTIALS), null, null, \Dingo\Api\Http\Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Log Me In
     * @param Authenticatable $user
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
                Attributes::USER => Photographer::returnTransformedItems($user, ListPhotographerTransformer::class),
            ]);

        }
        return GlobalHelpers::formattedJSONResponse(Messages::INVALID_CREDENTIALS, null, null, Response::HTTP_UNAUTHORIZED);
    }
}
