<?php
return [
    'ushahidi' => [
        'platform_api_url' => env('USHAHIDI_PLATFORM_API_URL'),
        'platform_api_key' => env('USHAHIDI_PLATFORM_API_KEY'),
        'shared_secret' => env('USHAHIDI_PLATFORM_SHARED_SECRET')
    ],
    'yodie' => [
        'api' => [
            'url' => env('YODIE_API_URL'),
            'key' => env('YODIE_API_KEY'),
            'secret' => env('YODIE_API_SECRET'),
        ],
        'request_per_time_block' => env('YODIE_QUOTA') / env('YODIE_REQUEST_COST'),
        'quota_reset' => env('YODIE_QUOTA_RESET')
    ],
    'crees' => [
        'api' => [
          'url' => env('CREES_API_URL'),
          'event_related' => env('CREES_EVENT_RELATED'),
          'event_type' => env('CREES_EVENT_TYPE'),
          'info_type' => env('CREES_INFO_TYPE'),
        ]
    ],
    'actionability' => [
        'api' => [
            'url' => env('ACTIONABILITY_API_URL'),
            'username' => env('ACTIONABILITY_API_USERNAME'),
            'password' => env('ACTIONABILITY_API_PASSWORD')
        ],
        'request_per_time_block' => env('ACTIONABILITY_QUOTA') / env('ACTIONABILITY_REQUEST_COST'),
        'quota_reset' => env('ACTIONABILITY_QUOTA_RESET')
    ]
];
