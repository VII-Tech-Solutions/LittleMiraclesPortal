<?php

namespace App\Constants;

class EnvVariables extends CustomEnum
{
    const TELESCOPE_ENABLED = "TELESCOPE_ENABLED";
    const SENTRY_ENABLED = "SENTRY_ENABLED";
    // MailJet
    const MAILJET_APIKEY = "MAILJET_APIKEY";
    const MAILJET_APISECRET = "MAILJET_APISECRET";
    const MAIL_FROM_ADDRESS = "MAIL_FROM_ADDRESS";
    const MAIL_FROM_NAME = "MAIL_FROM_NAME";
}
