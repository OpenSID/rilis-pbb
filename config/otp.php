<?php

return [
    /* OTP expiration in minutes */
    'expires_minutes' => env('OTP_EXPIRES_MINUTES', 5),

    /* Maximum number of times a code can be sent per request/session */
    'max_send' => env('OTP_MAX_SEND', 1),

    /* Maximum wrong attempts allowed for a single OTP */
    'max_attempts' => env('OTP_MAX_ATTEMPTS', 3),
];
