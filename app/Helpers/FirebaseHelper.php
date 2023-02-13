<?php

namespace App\Helpers;

use App\Constants\Attributes;
use App\Constants\Values;
use App\Models\Helpers;
use Exception;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\Messaging\ApiConnectionFailed;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Kreait\Firebase\Exception\Messaging\QuotaExceeded;
use Kreait\Firebase\Exception\Messaging\ServerError;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use VIITech\Helpers\GlobalHelpers;

/**
 * Firebase Helper
 */
class FirebaseHelper
{

    /**
     * Send FCM by Topic
     * @param string $topic
     * @param null $env
     * @param array $data
     * @return bool|Exception|FirebaseException
     */
    static function sendFCMByTopic($topic = Values::FCM_DEFAULT_TOPIC, $user_id = null, $env = null, $data = [], $with_debug = false, $count = 0)
    {

        try {
            $data = $data->except('_token');
            $title = $data[Attributes::TITLE] ?? null;
            $body = $data[Attributes::MESSAGE] ?? null;

            if (empty($env)) {
//                $env = GlobalHelpers::isProductionEnv() ? "production" : "local";
                $env = config('app.env');
            }

            if (empty($topic) || empty($title) || empty($body)) {
                return false;
            }

            if(!array_key_exists(Attributes::ROOM_ID, $data)){
                $data[Attributes::ROOM_ID] = null;
            }

            if(!array_key_exists(Attributes::FAMILY_ID, $data)){
                $data[Attributes::FAMILY_ID] = null;
            }

//            $message = CloudMessage::withTarget('topic', $topic)
//                ->withNotification(['title' => $title, 'body' => $body]);
//                ->withData($data); //for testing

            $message = CloudMessage::withTarget(Attributes::CONDITION, "'$topic' in topics && !('$env' in topics)")
                ->withNotification(['title' => $title, 'body' => $body])
                ->withData($data);

            $android_config = AndroidConfig::fromArray([
                Attributes::PRIORITY => Values::FCM_PRIORITY_ANDROID,
                Attributes::NOTIFICATION => [
                    Attributes::TITLE => $title,
                    Attributes::BODY => $body,
                    Attributes::COLOR => Values::FCM_COLOR,
                    Attributes::SOUND => Attributes::DEFAULT,
                ],
            ]);

            $apns_config = ApnsConfig::fromArray([
                Attributes::HEADERS => [
                    Attributes::APNS_PRIORITY => Values::FCM_PRIORITY_IOS,
                ],
                Attributes::PAYLOAD => [
                    Attributes::APS => [
                        Attributes::ALERT => [
                            Attributes::TITLE => $title,
                            Attributes::BODY => $body,
                        ],
                        Attributes::SOUND => Attributes::DEFAULT,
                        Attributes::BADGE => 1,
                    ],
                ],
            ]);

            $message = $message->withAndroidConfig($android_config)->withApnsConfig($apns_config);
dd($message);
            $base = (new Factory())->withProjectId(Values::FCM_PROJECT_ID)
                ->withServiceAccount(storage_path("firebase_credentials.json"));

            $result = $base->createMessaging()->send($message);
//            dd($result, 'test');

            return true;

        } catch (ServerError | QuotaExceeded | ApiConnectionFailed | InvalidMessage $e3){
            return false;
        } catch (Exception | FirebaseException $e2) {
            if($with_debug){
                return $e2;
            }
            Helpers::captureException($e2);
            return false;
        }
    }

    /**
     * Send FCM by Token
     * @param null $env
     * @param array $data
     * @return bool|Exception|FirebaseException
     */
    static function sendFCMByToken($token, $user_id = null, $env = null, $data = [], $with_debug = false, $count = 0)
    {
        try {

            $title = $data[Attributes::TITLE] ?? null;
            $body = $data[Attributes::MESSAGE] ?? null;

            if (empty($token) || empty($title) || empty($body)) {
                return false;
            }

            if(!array_key_exists(Attributes::CONVERSATION_ID, $data)){
                $data[Attributes::CONVERSATION_ID] = null;
            }

            $message = CloudMessage::withTarget(Attributes::TOKEN, $token)
                ->withNotification(Notification::fromArray([
                    Attributes::TITLE => $title,
                    Attributes::BODY => $body,
                ]))->withData($data);

            $android_config = AndroidConfig::fromArray([
                Attributes::PRIORITY => Values::FCM_PRIORITY_ANDROID,
                Attributes::NOTIFICATION => [
                    Attributes::TITLE => $title,
                    Attributes::BODY => $body,
                    Attributes::COLOR => Values::FCM_COLOR,
                    Attributes::SOUND => Attributes::DEFAULT,
                    Attributes::ICON => url('logo.png'),
                ],
            ]);

            $apns_config = ApnsConfig::fromArray([
                Attributes::HEADERS => [
                    Attributes::APNS_PRIORITY => Values::FCM_PRIORITY_IOS,
                ],
                Attributes::PAYLOAD => [
                    Attributes::APS => [
                        Attributes::ALERT => [
                            Attributes::TITLE => $title,
                            Attributes::BODY => $body,
                        ],
                        Attributes::SOUND => Attributes::DEFAULT,
                        Attributes::BADGE => 1,
                    ],
                ],
            ]);

            $message = $message->withAndroidConfig($android_config)->withApnsConfig($apns_config);

            $base = (new Factory())->withProjectId(Values::FCM_PROJECT_ID)
                ->withServiceAccount(storage_path("firebase_credentials.json"));

            $base->createMessaging()->send($message);

            return true;

        } catch (NotFound | InvalidMessage | ApiConnectionFailed $e3){
            if($count == 0){
                return self::sendFCMByTopic(Helpers::userTopic($user_id), $user_id, $env, $data, $with_debug, 1);
            }
            return false;
        }  catch (ServerError | QuotaExceeded $e3){
            return false;
        } catch (Exception | FirebaseException $e2) {
            if($with_debug){
                return $e2;
            }
            Helpers::captureException($e2);
            return false;
        }
    }


}
