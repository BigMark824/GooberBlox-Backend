<?php
/*
*   Source: Roblox.Web.Code.Properties
*/

return [
    "Default" => [
        "CookieConstraint_AllowedButtonValuesCSV" => env('COOKIE_CONSTRAINT_ALLOWED_BUTTONS', 'o,b,l,x'),
        "CookieConstraintCookieName" => env('COOKIE_CONSTRAINT_COOKIE_NAME', 'carrot6984cakeneim3k6gb3'),
        "IsCookieConstraintEnabled" => env('COOKIE_CONSTRAINT_ENABLED', true),
        "CookieConstraintMessage" => env('COOKIE_CONSTRAINT_MESSAGE', 'Service Undergoing Maintenance'),
        "CookieConstraintExpiration" => env('COOKIE_CONSTRAINT_EXPIRATION', '16.00:00:00'),
        "CookieConstraintIpBypassRangeCsv" => env('COOKIE_CONSTRAINT_IP_BYPASS', ''),
        "CookieConstraintPassword" => env('COOKIE_CONSTRAINT_PASSWORD', 'mouse'),
        "CookieConstraint_RedirectURL" => env('COOKIE_CONSTRAINT_REDIRECT_URL', '/Login/FulfillConstraint.aspx'),
        "CookieConstraint_RedirectDomain" => env('COOKIE_CONSTRAINT_REDIRECT_DOMAIN', ''),
        "GameServerHeaderBypassValue" => env('COOKIE_CONSTRAINT_SERVER_BYPASS', '#notmybypass'),
        "CookieConstraintPageCountDownUTCTime" => env('COOKIE_CONSTRAINT_COUNTDOWN_UTC', '1970-01-01'),
        "IsGameServerCookieConstraintBypassEnabled" => env('COOKIE_CONSTRAINT_GAME_SERVER_BYPASS_ENABLED', false),
    ],
];