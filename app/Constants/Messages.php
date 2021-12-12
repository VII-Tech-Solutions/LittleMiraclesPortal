<?php

namespace App\Constants;

class Messages extends CustomEnum
{
    const PERMISSION_DENIED = "Permission denied";
    const ITEM_NOT_FOUND = 'Item is not found';
    const BAD_REQUEST = 'Invalid parameters';
    const INVALID_PROVIDER = 'Invalid provider';
    const TOKEN_GENERATED = 'Token generated';
    const INVALID_CREDENTIALS = 'Invalid credentials';
    const ATTRIBUTE_REQUIRED = ":attribute is required";
    const MAX = ":attribute is required";
    const PROFILE_UPDATED = "Profile updated";
    const UNABLE_TO_PROCESS = "Unable to process your request";
    const ACCOUNT_DELETED = "Account has been deleted successfully";
    const PROMO_CODE_APPLIED = "Promo code applied";
    const UNABLE_TO_FIND_SESSION = "Unable to find the session";
}
