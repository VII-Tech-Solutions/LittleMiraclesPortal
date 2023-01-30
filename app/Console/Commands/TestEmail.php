<?php

namespace App\Console\Commands;

use App\Constants\Attributes;
use App\Helpers\MailjetHelpers;
use App\Models\Appointment;
use App\Models\BackpackUser;
use App\Models\Photographer;
use App\Models\Session;
use Illuminate\Console\Command;

class TestEmail extends Command
{
    protected $signature = 'test:email';
    protected $description = 'send emails for testing';
    public function handle()
    {
        $session = Session::where(Attributes::ID, 212)->first();
        $appointment = Appointment::where(Attributes::ID, 8)->first();
        MailjetHelpers::appointmentBooked($appointment);
    }
}
