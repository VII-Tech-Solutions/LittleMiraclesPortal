<?php

namespace App\Console\Commands;

use App\Helpers\FirebaseHelper;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use VIITech\Helpers\GlobalHelpers;

class TestNotificationCommand extends Command
{
    protected $signature = 'test:notification';
    protected $description = 'send notification for testing';

    public function handle()
    {
        Log::info("Test Notification");
        Log::info("Env: " . GlobalHelpers::isProductionEnv());

        /** @var User $users */
        $users = User::whereIn('id', [157, 19])->get();

        /** @var User $user */
        foreach ($users as $user) {
            Log::info("User First Name: " . $user->first_name);
            $notification = FirebaseHelper::sendFCMByToken($user->device_token, $user->id, null, ['title' => "Happy Birth Day!", 'message' => "It's your BIG DAY! Happy Birthday our Little Miracle  " . $user->first_name . " 🥳🎈"]);
            Log::info($notification);
        }
    }
}
