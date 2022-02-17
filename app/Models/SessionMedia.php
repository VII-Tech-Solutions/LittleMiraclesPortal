<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class Session Media
 * @package App\Models
 *
 * @property integer session_id
 * @property integer media_id
 * @property string status
 * @property integer order
 */
class SessionMedia extends CustomModel
{

    use ImageTrait;

    protected $table = Tables::SESSION_MEDIA;
    protected $guarded = [
        Attributes::ID
    ];
    protected $fillable = [
        Attributes::SESSION_ID,
        Attributes::MEDIA_ID,
        Attributes::STATUS,
        Attributes::ORDER,
    ];


    /**
     * Relationship: Media
     * @return BelongsTo
     */
    function media(){
        return $this->belongsTo(Media::class, Attributes::MEDIA_ID);
    }


    /**
     * Create or Update
     * @param array $data
     * @param array|null $find_by
     * @return static|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
        $data = array_map('intval', $data);
        $session_media = static::where(Attributes::SESSION_ID, $data[Attributes::SESSION_ID])
            ->where(Attributes::MEDIA_ID, $data[Attributes::SESSION_ID])->first();
        if (is_null($session_media)) {
            $session_media = new static();
        }
        if(!array_key_exists(Attributes::ORDER, $data)) {
            $data[Attributes::ORDER] = 1;
        }
        $session_media->fill($data);
        if($session_media->save()) {
            return $session_media;
        }
        return $session_media;
    }
}
