<?php

namespace App\Helpers;

use App\Constants\Attributes;
use App\Constants\EnvVariables;
use App\Constants\Messages;
use App\Constants\Roles;
use App\Models\Appointment;
use App\Models\Backdrop;
use App\Models\Helpers;
use App\Models\Photographer;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mailjet\Client;
use Mailjet\Resources;
use stdClass;
use VIITech\Helpers\GlobalHelpers;

class MailjetHelpers
{

    /**
     * Booking Confirmed
     * @param Session $session
     * @return JsonResponse|void
     */
    static function bookingConfirmed(Session $session) {
        // create Mailjet Client
        $mj = new Client(env(EnvVariables::MAILJET_APIKEY), env(EnvVariables::MAILJET_APISECRET), true, ['version' => 'v3.1']);

        // prepare data
        $data = new stdClass();
        $data->session_name = $session->title;
        $data->photographer_name = $session->photographer_name;
        $data->username = $session->user->first_name . ' ' . $session->user->last_name;
        $data->phone_number = $session->user->phone_number;
        $data->email = $session->user->email;
        $data->date = $session->date;
        $data->time = $session->time;
        $data->package_name = $session->package_name;
        $data->people = $session->people()->count();
        /** @var Backdrop $backdrops */
        $backdrops = $session->backdrops()->get();
        $backdrop = "";
        for ($i = 1; $i <= count($backdrops); $i++) {
            if (!empty($backdrop)) {
                $backdrop .= "<br>";
            }
            $backdrop .= "Backdrop $i: " . $backdrops[$i - 1 ]->title;
        }
        $data->backdrops = $backdrop;
        $data->cake_name = $session->formatted_cake;
        $data->comment = $session->comment ?? "-";

        $data = json_encode($data);

        // prepare body (customer)
        $body_customer = [
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
        // send email (customer)
        $response = $mj->post(Resources::$Email, ['body' => $body_customer]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // prepare body (photographer)
        $body_photographer = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => [
                        [
                            'Email' => $session->photographer_email,
                            'Name' => $session->photographer_name
                        ]
                    ],
                    'TemplateID' => 4510606,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (photographer)
        $response = $mj->post(Resources::$Email, ['body' => $body_photographer]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // prepare body (admin)
        /** @var Photographer $admins */
        $admins = Photographer::where(Attributes::ROLE, Roles::ADMIN)->get();
        $to_emails = array();
        foreach ($admins as $admin) {
            $to_emails[] =  [
                'Email' => $admin->email,
                'Name' => $admin->name
            ];
        }
        $body_admin = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => $to_emails,
                    'TemplateID' => 4510797,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (admin)
        $response = $mj->post(Resources::$Email, ['body' => $body_admin]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Booking Rescheduled
     * @param Session $session
     * @return JsonResponse|void
     */
    static function bookingRescheduled(Session $session) {
        // create Mailjet Client
        $mj = new Client(env(EnvVariables::MAILJET_APIKEY), env(EnvVariables::MAILJET_APISECRET), true, ['version' => 'v3.1']);

        // prepare data
        $data = new stdClass();
        $data->session_name = $session->title;
        $data->photographer_name = $session->photographer_name;
        $data->username = $session->user->first_name . ' ' . $session->user->last_name;
        $data->day = Carbon::parse($session->date)->format('l');
        $data->phone_number = $session->user->phone_number;
        $data->email = $session->user->email;
        $data->date = $session->date;
        $data->time = $session->time;
        $data->package_name = $session->package_name;
        $data->people = $session->people()->count();
        /** @var Backdrop $backdrops */
        $backdrops = $session->backdrops()->get();
        $backdrop = "";
        for ($i = 1; $i <= count($backdrops); $i++) {
            if (!empty($backdrop)) {
                $backdrop .= "<br>";
            }
            $backdrop .= "Backdrop $i: " . $backdrops[$i - 1 ]->title;
        }
        $data->backdrops = $backdrop;
        $data->cake_name = $session->formatted_cake;
        $data->comment = $session->comment ?? "-";

        $data = json_encode($data);

        // prepare body (customer)
        $body_customer = [
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
                    'TemplateID' => 4511304,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (customer)
        $response = $mj->post(Resources::$Email, ['body' => $body_customer]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // prepare body (photographer)
        $body_photographer = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => [
                        [
                            'Email' => $session->photographer_email,
                            'Name' => $session->photographer_name
                        ]
                    ],
                    'TemplateID' => 4511315,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (photographer)
        $response = $mj->post(Resources::$Email, ['body' => $body_photographer]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // prepare body (admin)
        /** @var Photographer $admins */
        $admins = Photographer::where(Attributes::ROLE, Roles::ADMIN)->get();
        $to_emails = array();
        foreach ($admins as $admin) {
            $to_emails[] =  [
                'Email' => $admin->email,
                'Name' => $admin->name
            ];
        }
        $body_admin = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => $to_emails,
                    'TemplateID' => 4511348,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (admin)
        $response = $mj->post(Resources::$Email, ['body' => $body_admin]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Appointment Booked
     * @param Appointment $appointment
     * @return JsonResponse|void
     */
    static function appointmentBooked(Appointment $appointment) {
        // create Mailjet Client
        $mj = new Client(env(EnvVariables::MAILJET_APIKEY), env(EnvVariables::MAILJET_APISECRET), true, ['version' => 'v3.1']);

        // prepare data
        $data = new stdClass();
        $data->photographer_name = $appointment->session->photographer_name;
        $data->username = $appointment->user->first_name . ' ' . $appointment->user->last_name;
        $data->package_name = $appointment->session->package_name;
        $data->email = $appointment->user->email;
        $data->phone_number = $appointment->user->phone_number;
        $data->date = $appointment->date;
        $data->time = $appointment->time;
        $data->session_name = $appointment->session->title;

        $data = json_encode($data);

        // prepare body (customer)
        $body_customer = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => [
                        [
                            'Email' => $appointment->user->email,
                            'Name' => $appointment->user->first_name . ' ' . $appointment->user->last_name
                        ]
                    ],
                    'TemplateID' => 4515694,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (customer)
        $response = $mj->post(Resources::$Email, ['body' => $body_customer]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }

        // prepare body (photographer)
        $body_photographer = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => [
                        [
                            'Email' => $appointment->session->photographer_email,
                            'Name' => $appointment->session->photographer_name
                        ]
                    ],
                    'TemplateID' => 4515667,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (photographer)
        $response = $mj->post(Resources::$Email, ['body' => $body_photographer]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }


        // prepare body (admin)
        /** @var Photographer $admins */
        $admins = Photographer::where(Attributes::ROLE, Roles::ADMIN)->get();
        $to_emails = array();
        foreach ($admins as $admin) {
            $to_emails[] =  [
                'Email' => $admin->email,
                'Name' => $admin->name
            ];
        }
        $body_admin = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => env(EnvVariables::MAIL_FROM_ADDRESS),
                        'Name' => env(EnvVariables::MAIL_FROM_NAME)
                    ],
                    'To' => $to_emails,
                    'TemplateID' => 4515670,
                    'TemplateLanguage' => true,
                    'Variables' => json_decode($data, true)
                ]
            ]
        ];
        // send email (admin)
        $response = $mj->post(Resources::$Email, ['body' => $body_admin]);

        // return response
        if (!$response->success()) {
            return GlobalHelpers::formattedJSONResponse(Messages::UNABLE_TO_PROCESS, null, null, Response::HTTP_BAD_REQUEST);
        }
    }
}
