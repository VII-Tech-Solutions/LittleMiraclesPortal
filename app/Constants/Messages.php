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
    const REVIEW_SUBMITTED = "Review submitted successfully";
    const FEEDBACK_SUBMITTED = "Feedback submitted successfully";
    const GUIDELINE_GENERATED_SUCCESSFULLY = "Guideline generated successfully";
    const UNABLE_TO_FIND_SESSION = "Unable to find the session";
    const UNABLE_TO_FIND_PACKAGE = "Unable to find the package";
    const INVALID_PROMOTION_CODE = "Invalid promotion code";
    const PROMOTION_CODE_EXPIRED = "Promotion code expired";
    const SESSION_HAS_A_PROMOTION_CODE = "Promotion code is used previously";
    const GIFT_CLAIMED = "Gift claimed successfully";
    const SESSION_ALREADY_CONFIRMED = "This session has been already confirmed before";
    const SESSION_CONFIRMED = "Session confirmed successfully";

}
