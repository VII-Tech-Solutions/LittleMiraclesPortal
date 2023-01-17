<?php

namespace App\Traits;

use App\Constants\ReviewStatus;
use App\Constants\Status;
use App\Models\Helpers;

/**
 * Model Trait
 */
trait ModelTrait
{

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getStatusName($value)
    {
        $text = Status::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: status_name
     * @param $value
     * @return string
     */
    public function getReviewStatusName($value)
    {
        $text = ReviewStatus::getKey($this->status);
        return Helpers::readableText($text);
    }

    /**
     * Get Attribute: user_name
     * @return string
     */
    public function getUserNameAttribute()
    {
        $user = $this->user;
        if(is_null($user)){
            return null;
        }
        return $user->full_name;
    }

}
