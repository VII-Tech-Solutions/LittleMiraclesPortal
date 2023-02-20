<?php

namespace App\Console\Commands;

use App\Constants\Attributes;
use App\Constants\SessionStatus;
use App\Constants\Values;
use App\Models\Session;
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
            // photo shoot day
            if ($session->date == $today_date) {
                $session->status = SessionStatus::PHOTOSHOOT_DAY;
            } // Magic making in progress
            else if ($today_date >= Carbon::parse($session->date)->addDay()->format(Values::CARBON_DATE_FORMAT) && $today_date < Carbon::parse($session->date)->addDays(14)->format(Values::CARBON_DATE_FORMAT)) {
                $session->status = SessionStatus::MAGIC_MAKING;
            } // Getting all your photos in order
            else if ($today_date >= Carbon::parse($session->date)->addDays(14)->format(Values::CARBON_DATE_FORMAT) && $today_date < Carbon::parse($session->date)->addDays(28)->format(Values::CARBON_DATE_FORMAT)) {
                $session->status = SessionStatus::GETTING_IN_ORDER;
            } // Your photos are ready!
            else if ($today_date >= Carbon::parse($session->date)->addDays(28)->format(Values::CARBON_DATE_FORMAT)) {
                $session->status = SessionStatus::READY;
            }
            $session->save();
        }
    }
}
