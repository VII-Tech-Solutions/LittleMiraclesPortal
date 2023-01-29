<?php

namespace App\Helpers;

use App\Constants\EnvVariables;
use App\Constants\Messages;
use App\Models\Helpers;
use App\Models\Session;
use Illuminate\Http\Response;
use Mailjet\Client;
use Mailjet\Resources;
use stdClass;
use VIITech\Helpers\GlobalHelpers;

class MailjetHelpers
{

    static function customerBookingConfirmed(Session $session) {
        // create Mailjet Client
        $mj = new Client(env(EnvVariables::MAILJET_APIKEY), env(EnvVariables::MAILJET_APISECRET), true, ['version' => 'v3.1']);

        // prepare data
        $data = new stdClass();
        $data->session_name = $session->title;
        $data->photographer_name = $session->photographer_name;
        $data->username = $session->user->first_name . ' ' . $session->user->last_name;
        $data->date = $session->date;
        $data->time = $session->time;
        $data->people = $session->people()->count();
        $data->backdrop1_name = $session->formatted_backdrop;
        $data->cake_name = $session->formatted_cake;
        $data->comment = $session->comment ?? "";


        $data = json_encode($data);


        // prepare body
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => [
                        [
                            'Email' => $session->user->email,
                            'Name' => $session->user->first_name . ' ' . $session->user->last_name
                        ]
                    ],
                    'TemplateID' => 4509155,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

    }
}
