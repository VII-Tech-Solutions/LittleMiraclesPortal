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

    /**
     * Get Readable Text
     */
    static function readableText($text)
    {
        return ucwords(strtolower(str_replace("_", " ", $text)));
    }

    /**
     * Parse Query
     * @param $str
     * @param $urlEncoding
     * @return array
     */
    static function parseQuery($str, $urlEncoding = true)
    {
        $result = [];

        if ($str === '') {
            return $result;
        }

        if ($urlEncoding === true) {
            $decoder = function ($value) {
                return rawurldecode(str_replace('+', ' ', $value));
            };
        } elseif ($urlEncoding === PHP_QUERY_RFC3986) {
            $decoder = 'rawurldecode';
        } elseif ($urlEncoding === PHP_QUERY_RFC1738) {
            $decoder = 'urldecode';
        } else {
            $decoder = function ($str) { return $str; };
        }

        foreach (explode('&', $str) as $kvp) {
            $parts = explode('=', $kvp, 2);
            $key = $decoder($parts[0]);
            $value = isset($parts[1]) ? $decoder($parts[1]) : null;
            if (!isset($result[$key])) {
                $result[$key] = $value;
            } else {
                if (!is_array($result[$key])) {
                    $result[$key] = [$result[$key]];
                }
                $result[$key][] = $value;
            }
        }

        return $result;
    }
}
