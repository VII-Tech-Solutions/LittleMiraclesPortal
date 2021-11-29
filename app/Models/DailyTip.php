<?php


namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Status;
use App\Constants\Tables;
use App\Helpers;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use VIITech\Helpers\Constants\CastingTypes;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyTip extends CustomModel
{

    protected $table = Tables::DAILY_TIP;

    protected $guarded = [
        Attributes::ID
    ];

    protected $fillable = [
        Attributes::IMAGE, Attributes::TITLE,Attributes::POSTED_AT, Attributes::CONTENT, Attributes::STATUS,
    ];

    protected $casts = [
        Attributes::TITLE => CastingTypes::STRING,
        Attributes::POSTED_AT => CastingTypes::STRING,
        Attributes::CONTENT => CastingTypes::STRING,
        Attributes::STATUS => CastingTypes::INTEGER,
    ];

    protected $appends = [
        Attributes::STATUS_NAME
    ];

    public function getStatusNameAttribute($value)
    {
        $text = Status::getKey( $this->status);
        return Helpers::readableText($text);
    }

    /**
     * Set Attribute: Image
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if(!is_null($value)){
            $path = Helpers::uploadFile($this, $value, Attributes::IMAGE, "uploads/photographers", true, false, true);
            $this->attributes[Attributes::IMAGE] = $path;
        }else{
            $this->attributes[Attributes::IMAGE] = null;
        }
    }
}
