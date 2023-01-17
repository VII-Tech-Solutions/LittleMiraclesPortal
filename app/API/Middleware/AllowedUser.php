<?php

namespace App\API\Middleware;

use App\Constants\Attributes;
use App\Constants\Messages;
use App\Models\Helpers;
use App\Models\User;
use Closure;
use Dingo\Api\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use VIITech\Helpers\GlobalHelpers;

/**
 * Class AllowedUser
 * @package App\API\Middleware
 */
class AllowedUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param boolean $public_for_all
     * @return mixed
     */
    public function handle($request, Closure $next, $public_for_all = false)
    {

        try {

            /** @var User $user */
            $user = Auth::guard("api")->user();
            if (is_null($user) && !$public_for_all) {
                return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
            }

            if(!is_null($user)){
                app()->instance(Attributes::USER, $user);
                if(!is_null($user->id)){
                    app()->instance(Attributes::USER_ID, $user->id);
                }
            }

        } catch (Exception $e) {
            Helpers::captureException($e);
        }

        return $next($request);
    }
}
