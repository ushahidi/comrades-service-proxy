<?php
return [
    'ushahidi' => [
        'platform_api_url' => env('USHAHIDI_PLATFORM_API_URL'),
        'platform_api_key' => env('USHAHIDI_PLATFORM_API_KEY'),
        'shared_secret' => env('USHAHIDI_PLATFORM_SHARED_SECRET')
    ],
    'yodie' => [
        'api' => [
            'url' => env('YODIE_API_URL', null),
            'key' => env('YODIE_API_KEY', null),
            'secret' => env('YODIE_API_SECRET', null),
        ],
        'request_per_time_block' => env('YODIE_QUOTA', 1) / env('YODIE_REQUEST_COST', 1),
        'quota_reset' => env('YODIE_QUOTA_RESET', null)
    ],
    'crees' => [
        'api' => [
          'url' => env('CREES_API_URL', null),
          'event_related' => env('CREES_EVENT_RELATED', null),
          'event_type' => env('CREES_EVENT_TYPE', null),
          'info_type' => env('CREES_INFO_TYPE', null),
        ]
    ],
    'actionability' => [
        'api' => [
            'url' => env('ACTIONABILITY_API_URL')
        ]
    ]
];
