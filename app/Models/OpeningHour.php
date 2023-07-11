<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Constants\Values;
use Illuminate\Support\Carbon;

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

    public function setFromAttribute($value)
    {
        $this->attributes['from'] = Carbon::parse($value)->format(Values::CARBON_HOUR_FORMAT);
    }

    public function getFromAttribute($value)
    {
        return Carbon::parse($value)->format(Values::CARBON_24_HOUR_FORMAT);
    }

    public function setToAttribute($value)
    {
        $this->attributes['to'] = Carbon::parse($value)->format(Values::CARBON_HOUR_FORMAT);
    }

    public function getToAttribute($value)
    {
        return Carbon::parse($value)->format(Values::CARBON_24_HOUR_FORMAT);
    }
}


