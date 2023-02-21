<?php

namespace App\Console\Commands;

use App\Constants\Attributes;
use App\Constants\SessionStatus;
use App\Constants\Values;
use App\Helpers\FirebaseHelper;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SessionStatusCommand extends Command
{
    protected $signature = 'session:status';
    protected $description = 'change session status';

    public function handle()
    {
        // get all sessions
        /** @var Session sessions */
        $sessions = Session::whereNotIn(Attributes::STATUS, [SessionStatus::UNPAID, SessionStatus::READY])->get();

        // today's date
        $today_date = Carbon::now()->format(Values::CARBON_DATE_FORMAT);

        // check sessions
        /** @var Session $session */
        foreach ($sessions as $session) {
            /** @var User $user */
            $user = $session->user;

            // photo shoot day
            if ($session->date == $today_date) {
                // change status
                $session->status = SessionStatus::PHOTOSHOOT_DAY;
                // prepare notification
                $notification_body = [
                    "title" => "Day of the Session",
                    "message" => "IT'S PHOTOSHOOT DAY! Your $session->title session is scheduled for today at $session->time!",
                ];
            } // Magic making in progress
            else if ($today_date >= Carbon::parse($session->date)->addDay()->format(Values::CARBON_DATE_FORMAT) && $today_date < Carbon::parse($session->date)->addDays(14)->format(Values::CARBON_DATE_FORMAT)) {
                // change status
                $session->status = SessionStatus::MAGIC_MAKING;
                // prepare notification
                $notification_body = [
                    "title" => "Photos are ready",
                    "message" => "Great news, $user->first_name $user->last_name! Your photos from the $session->title session are ready!",
                ];
            } // Getting all your photos in order
            else if ($today_date >= Carbon::parse($session->date)->addDays(14)->format(Values::CARBON_DATE_FORMAT) && $today_date < Carbon::parse($session->date)->addDays(28)->format(Values::CARBON_DATE_FORMAT)) {
                $session->status = SessionStatus::GETTING_IN_ORDER;
            } // Your photos are ready!
            else if ($today_date >= Carbon::parse($session->date)->addDays(28)->format(Values::CARBON_DATE_FORMAT)) {
                $session->status = SessionStatus::READY;
            }

            // update status
            $session->save();

            // send notification
            if (isset($notification_body)) {
                $notification = FirebaseHelper::sendFCMByToken($user->device_token, $user->id, null, $notification_body);
            }
        }
    }
}
