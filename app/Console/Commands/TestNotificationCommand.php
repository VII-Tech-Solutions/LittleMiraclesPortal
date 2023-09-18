<?php

namespace App\Console\Commands;

use App\Helpers\FirebaseHelper;
use App\Models\Photographer;
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

        /** @var Photographer $admin_user */
        $users = Photographer::whereIn('id', [1])->get();
//        /** @var User $users */
//        $users = User::whereIn('id', [157, 19])->get();

        /** @var Photographer $user */
        foreach ($users as $user) {
            Log::info("User First Name: " . $user->name);
            $notification = FirebaseHelper::sendFCMByToken($user->device_token, $user->id, null, ['title' => "Happy Birth Day!", 'message' => "It's your BIG DAY! Happy Birthday our Little Miracle  " . $user->name . " 🥳🎈"]);
            Log::info($notification);
        }
    }
}
