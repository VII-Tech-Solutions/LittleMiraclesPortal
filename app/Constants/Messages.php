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
    const UNABLE_TO_UPDATE_STATUS = "Unable to update status";
    const ACCOUNT_DELETED = "Account has been deleted successfully";
    const PROMO_CODE_APPLIED = "Promo code applied";
    const PROMO_CODE_REMOVED = "Promo code removed";
    const REVIEW_SUBMITTED = "Review submitted successfully";
    const FEEDBACK_SUBMITTED = "Feedback submitted successfully";
    const GUIDELINE_GENERATED_SUCCESSFULLY = "Guideline generated successfully";
    const UNABLE_TO_FIND_SESSION = "Unable to find the session";
    const UNABLE_TO_FIND_PACKAGE = "Unable to find the package";
    const UNABLE_TO_FIND_SUB_PACKAGE = "Unable to find sub-package";
    const INVALID_PROMOTION_CODE = "Invalid promotion code";
    const PROMOTION_CODE_NOT_FOR_THIS_PACKAGE = "Invalid promotion code for the current package";
    const PROMOTION_CODE_EXPIRED = "Promotion code expired";
    const PROMOTION_CODE_IS_USED_PREVIOUSLY = "Promotion code is used previously";
    const SESSION_HAS_PROMO_CODE_APPLIED = "Session has promotion applied";
    const GIFT_CLAIMED = "Gift claimed successfully";
    const SESSION_ALREADY_CONFIRMED = "This session has been already confirmed";
    const SESSION_CONFIRMED = "Session confirmed successfully";
    const SESSION_APPOINTMENT_BOOKED = "Session appointment booked successfully";
    const SESSION_RESCHEDULED = "Session rescheduled successfully";
    const INVALID_PARAMETERS = "Invalid parameters";
    const PROFILE_UPDATE_REQUESTED = "Your profile information has been updated successfully";
    const CHILDREN_UPDATE_REQUESTED = "Your children information has been updated successfully";
    const PARTNER_UPDATE_REQUESTED = "Your partner information has been updated successfully";
    const FAMILY_INFO_UPDATE_REQUESTED = "Your family information has been updated successfully";
    const MESSAGE_SENT = "Message sent successfully";
    const CART_ITEM_ADDED = "Cart item added successfully";
    const CART_ITEM_REMOVED = "Cart item has been removed successfully";
    const ORDER_CREATED = "Order created successfully";
    const PARTNER_REMOVED = "Partner removed successfully";
    const PARTNER_NOT_FOUND = "Partner not found";
    const PACKAGE_NOT_FOUND = "Package not found";
    const WRONG_PACKAGE = "Promo code can be only applied on the selected package";
    const PROMOTION_CODE_ALREADY_REDEEMED = "Promotion code already redeemed";
    const INVALID_BOOKING_TYPE = "Invalid booking type";
    const INVALID_BOOKING_DATE_TIME = "Sorry, the date & time you selected is no longer available";
}
