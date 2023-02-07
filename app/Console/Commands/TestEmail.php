<?php

namespace App\Console\Commands;

use App\API\Controllers\SessionController;
use App\Constants\Attributes;
use App\Helpers\MailjetHelpers;
use App\Models\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestEmail extends Command
{
    protected $signature = 'test:email';
    protected $description = 'send emails for testing';
    public function handle()
    {
        $session = Session::where(Attributes::ID, 354)->first();
        $pdf = SessionController::generateInvoice($session->id);
        $filename = "invoice-" . $session->id . ".pdf";
        Storage::put("./public/invoices/$filename", $pdf);
        MailjetHelpers::bookingConfirmed($session, $filename);
    }
}
