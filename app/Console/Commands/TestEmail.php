<?php

namespace App\Console\Commands;

use App\API\Controllers\SessionController;
use App\Constants\Attributes;
use App\Helpers\MailjetHelpers;
use App\Models\Promotion;
use App\Models\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use VIITech\Helpers\GlobalHelpers;

class TestEmail extends Command
{
    protected $signature = 'test:email';
    protected $description = 'send emails for testing';

    public function handle()
    {
        $gift = Promotion::find(6465);
        MailjetHelpers::sendGift($gift);
    }
}
