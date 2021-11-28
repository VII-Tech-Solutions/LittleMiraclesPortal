<?php

namespace App;

use App\Constants\Attributes;
use App\Constants\EnvVariables;
use App\Models\User;
use App\Models\Photographers;
use Exception;
use Illuminate\Support\Facades\Auth;
use Sentry\State\Scope;
use Throwable;
use VIITech\Helpers\Constants\DebuggerLevels;
use VIITech\Helpers\GlobalHelpers;
use function Sentry\captureException;
use function Sentry\configureScope;

class Helpers
{

    /**
     * Capture Exception
     * @param $exception
     */
    static function captureException($exception){
        if(GlobalHelpers::isDevelopmentEnv()){
            dd($exception);
        }
        $level = DebuggerLevels::INFO;
        if (!is_null($exception) && is_a($exception, Throwable::class)) {
            if (env(EnvVariables::SENTRY_ENABLED, false)) {
                $user_id = self::resolveUserID();
                if(!is_null($user_id)){
                    configureScope(function (Scope $scope) use($user_id): void {
                        $scope->setUser([Attributes::USER_ID => $user_id]);
                    });
                }
                captureException($exception);
            }
            $level = DebuggerLevels::ERROR;
        }
        GlobalHelpers::debugger($exception, $level);
    }

    /**
     * Resolve User
     * @return User
     */
    static function resolveUser(){
        try {
            $user =  resolve(Attributes::USER);
            if(is_null($user)){
                $user = Auth::guard("api")->user();
            }
            if(is_null($user)){
                $user = Auth::guard("web")->user();
            }
            return $user;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Resolve User ID
     * @return string
     */
    static function resolveUserID(){
        try {
            $user_id = resolve(Attributes::USER_ID);
            if(is_null($user_id)){
                $user = self::resolveUser();
                if(!is_null($user)){
                    $user_id = $user->id;
                }
            }
            return $user_id;
        } catch (Exception $e) {
            return null;
        }
    }

    static function readableText($text){
        return ucwords(strtolower(str_replace("_", " ", $text)));
    }

}
