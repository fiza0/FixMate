<?php

return [
    // Number of handymen to notify for "Book Now" requests
    'book_now_notify_count' => env('BOOK_NOW_NOTIFY_COUNT', 5),
    
    // Maximum distance (in km) to search for handymen
    'max_search_distance' => env('MAX_SEARCH_DISTANCE', 10),
    
    // Booking expiration time (minutes) if no handyman accepts
    'booking_expiration_minutes' => env('BOOKING_EXPIRATION_MINUTES', 30),
    
    // Notification channels
    'notification_channels' => [
        'push' => env('ENABLE_PUSH_NOTIFICATIONS', true),
        'email' => env('ENABLE_EMAIL_NOTIFICATIONS', true),
        'sms' => env('ENABLE_SMS_NOTIFICATIONS', false),
    ],
    
    // SMS provider (for future implementation)
    'sms_provider' => env('SMS_PROVIDER', 'twilio'),
];