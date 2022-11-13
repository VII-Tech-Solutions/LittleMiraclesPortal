<?php

namespace App\Console\Commands;

use App\Constants\Attributes;
use App\Models\BackpackUser;
use App\Models\Photographer;
use Illuminate\Console\Command;

class CreatePhotographerUser extends Command
{
    protected $signature = 'photographer:user';
    protected $description = 'create admin users for photographers';
    public function handle()
    {
        $photographers = Photographer::all();
        $count = 0;
        $emails = ["sherin@littlemiracles.com","noni@littlemiracles.com","zahra@littlemiracles.com","marjan@littlemiracles.com"];
        foreach ($photographers as $photographer) {
            BackpackUser::createOrUpdate([
                Attributes::NAME => $photographer->name,
                Attributes::EMAIL => $emails[$count],
                Attributes::PASSWORD => 'password',
                Attributes::PHOTOGRAPHER_ID => $photographer->id
            ], [
                Attributes::PHOTOGRAPHER_ID
            ]);
            $count++;
        }
    }
}
