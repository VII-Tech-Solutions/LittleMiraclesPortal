<?php

namespace App\Models;

use App\Constants\EnvVariables;
use Exception;
use Throwable;
use VIITech\Helpers\Constants\DebuggerLevels;
use VIITech\Helpers\GlobalHelpers;
use function Sentry\captureException;

class Helpers
{
    /**
     * Capture Exception
     * @param Exception|string $exception
     */
    static function captureException($exception, $data = null)
    {
        if (GlobalHelpers::isDevelopmentEnv() && is_a($exception, Exception::class)) {
            dd($exception, $data);
        }
        $level = DebuggerLevels::INFO;
        if (!is_null($exception) && is_a($exception, Throwable::class)) {
            if (env(EnvVariables::SENTRY_ENABLED, false)) {
                captureException($exception);
            }
            $level = DebuggerLevels::ERROR;
        }
        GlobalHelpers::debugger($exception, $level);
    }

    /**
     * Append Env Number
     * @return int|null
     */
    static function appendEnvNumber(){
        $env = env("APP_ENV");
        switch ($env){
            case "local":
                return 1;
            case "beta":
                return 2;
            case "staging":
                return 3;
            case "production":
                return 4;
            default:
                return null;
        }
    }


    /**
     * Generate Big Random Number
     * @param int $len
     *
     * @return string
     */
    static function generateBigRandomNumber( $len = 9 ) {
        $rand   = '';
        while( !( isset( $rand[$len-1] ) ) ) {
            $rand   .= mt_rand( );
        }
        return substr( $rand , 0 , $len );
    }

    /**
     * Get Benefit Alias
     * @return string|null
     */
    static function getBenefitAlias() {
        $alias_path = Helpers::getBenefitAuthFolderPath() . "alias.txt";
        return trim(file_get_contents($alias_path));
    }

    /**
     * Get Auth Folder Path
     * @return string|null
     */
    static function getBenefitAuthFolderPath() {
        return storage_path("app/benefit/" . env("BENEFIT_ENVIRONMENT", "test") . "/");
    }

}
