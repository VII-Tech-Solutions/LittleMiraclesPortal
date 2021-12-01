<?php

namespace App\Traits;

use App\Constants\Status;
use App\Helpers;

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

}