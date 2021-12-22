<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;

/**
 * Opening Hours
 */
class OpeningHour extends CustomModel
{

    protected $table = Tables::OPENING_HOURS;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::AVAILABLE_DATE_ID,
        Attributes::DAY,
        Attributes::DAY_ID,
        Attributes::FROM,
        Attributes::TO,
        Attributes::STATUS,
    ];

    /**
     * Create or Update
     * @param array $data
     * @param $find_by
     * @return OpeningHour|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
        return parent::createOrUpdate($data, [
            Attributes::AVAILABLE_DATE_ID, Attributes::DAY_ID, Attributes::FROM, Attributes::TO, Attributes::STATUS
        ]);
    }
}


