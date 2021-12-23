<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\AvailableDateType;
use App\Constants\Tables;
use App\Helpers;
use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Available Date
 *
 * @property string start_date
 * @property string end_date
 * @property-read string date
 * @property string type
 * @property-read string type_name
 * @property-read string status_name
 * @property Collection hours
 */
class AvailableDate extends CustomModel
{

    use ModelTrait;

    protected $table = Tables::AVAILABLE_DATES;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::START_DATE,
        Attributes::END_DATE,
        Attributes::TYPE,
        Attributes::STATUS,
    ];

    protected $appends = [
        Attributes::DATE,
        Attributes::TIMINGS
    ];

    /**
     * Relationships: Hours
     * @return HasMany
     */
    public function hours()
    {
        return $this->hasMany(OpeningHour::class, Attributes::AVAILABLE_DATE_ID)
            ->orderBy(Attributes::DAY_ID)->orderBy(Attributes::FROM)
            ->whereNull(Tables::OPENING_HOURS.".".Attributes::DELETED_AT);
    }


    /**
     * Get full_date Attribute
     * @return string
     */
    function getFullDateAttribute(){
        return "From " . $this->start_date . " To " . $this->end_date;
    }

    /**
     * Get date Attribute
     * @return string
     */
    function getDateAttribute(){
        return $this->start_date;
    }

    /**
     * Get timings Attribute
     * @return Collection
     */
    function getTimingsAttribute(){
        return $this->hours->pluck(Attributes::FROM)->map(function ($item){
            return Carbon::parse($item)->format("g:i A");
        })->sort();
    }

    /**
     * Get type_name Attribute
     * @return string
     */
    function getTypeNameAttribute(){
        $text = AvailableDateType::getKey($this->type);
        return Helpers::readableText($text);
    }

    /**
     * Get status_name Attribute
     * @return string
     */
    function getStatusNameAttribute(){
        return $this->getStatusName($this->status);
    }
}


