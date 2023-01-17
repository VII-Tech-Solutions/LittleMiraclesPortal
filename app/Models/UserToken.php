<?php

namespace App\Models;

use App\Constants\Attributes;
use App\Constants\Tables;
use App\Helpers\FirebaseHelper;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * Class UserToken
 * @package App\Models
 *
 * @property string token
 * @property string platform
 * @property int user_id
 * @property User user
 */
class UserToken extends CustomModel
{

    use CrudTrait;

    protected $table = Tables::USER_TOKENS;
    protected $fillable = [
        Attributes::ID, Attributes::TOKEN, Attributes::PLATFORM,
        Attributes::USER_ID, Attributes::STATUS
    ];

    /**
     * Create or Update Item
     * @param array $data
     * @param null $find_by
     * @return UserToken|null
     */
    public static function createOrUpdate(array $data, $find_by = null)
    {
        return parent::createOrUpdate($data, [
            Attributes::USER_ID,
            Attributes::TOKEN,
        ]);
    }

    /**
     * Send FCM by Tokens
     * @param $user_id
     * @param $env
     * @param $data
     * @param $with_debug
     * @return bool
     */
    static function sendFCMByToken($user_id, $env, $data, $with_debug = false){
        /** @var Collection $user_tokens */
        if(is_null($user_id)){
            return false;
        }
        $user_tokens = UserToken::where(Attributes::USER_ID, $user_id)->orderByDesc(Attributes::CREATED_AT)->pluck(Attributes::TOKEN);
        if($user_tokens->isEmpty()){
            return FirebaseHelper::sendFCMByTopic(Helpers::userTopic($user_id), $user_id, $env, $data, $with_debug);
        }
        foreach ($user_tokens as $user_token){
            FirebaseHelper::sendFCMByToken($user_token, $user_id, $env, $data, $with_debug);
        }
        return true;
    }

    /**
     * Relationship: User
     * @return BelongsTo
     */
    function user(){
        return $this->belongsTo(User::class, Attributes::USER_ID);
    }
}
