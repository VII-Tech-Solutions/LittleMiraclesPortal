<?php

namespace App\Constants;

class Values extends CustomEnum
{
    const ITEMS_PER_PAGE = 10;
    const DEFAULT_PAGE = 1;
    const NO_RESOURCE_KEY = "NO_RESOURCE_KEY";
    const DEFAULT_TIMEZONE = "Asia/Bahrain";
    const CARBON_HOUR_FORMAT = "g:i A";
    const CARBON_DATE_FORMAT = "Y-m-d";
    const TEST_AMOUNT = 0.1;
    const VAT_AMOUNT = 0.1;
    const PASSWORD_POLICY = 'string|required|between:6,20|regex:/^(?=.*[a-z])(?=.*\d).{6,20}/';

    // FCM
    const FCM_DEFAULT_TOPIC = "lms";
    const FCM_PROJECT_ID = "little-miracles-app";
    const FCM_PRIORITY_IOS = "10";
    const FCM_PRIORITY_ANDROID = "high";
    const FCM_COLOR = "#ff4f69";
}
