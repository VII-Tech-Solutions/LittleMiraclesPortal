<?php

namespace App\Console\Commands;

use App\Constants\Relationship;
use App\Helpers\FirebaseHelper;
use App\Models\FamilyMember;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class HappyBirthdayCommand extends Command
{

    protected $signature = 'birthday:notification';

    protected $description = 'Happy Birthday Notification Command';

    public function handle()
    {
        $today_date = Carbon::now()->format('m-d');
        $children = FamilyMember::where('relationship', Relationship::CHILDREN)->get();
        /** @var FamilyMember $child */
        foreach ($children as $child) {
            if (Carbon::parse($child->birth_date)->format('m-d') == $today_date) {
                // get user
                $parent = $child->user;
                $notification = FirebaseHelper::sendFCMByToken($parent->device_token, $parent->id, null, ['title' => "Happy Birthday!", 'message' => "It's your BIG DAY! Happy Birthday our Little Miracle " . $child->first_name . " 🥳🎈"]);
            }
        }
    }
}
