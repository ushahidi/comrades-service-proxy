<?php
return [
    'ushahidi' => [
        'platform_api_url' => env('USHAHIDI_PLATFORM_API_URL'),
        'survey_source_field' => env('USHAHIDI_PLATFORM_SOURCE_SURVEY_FIELD_NAME'),
        'survey_destination_field' => env('USHAHIDI_PLATFORM_DESTINATION_SURVEY_FIELD_NAME'),
    ],
    'yodie' => [
        'api' => [
            'url' => env('YODIE_API_URL'),
            'key' => env('YODIE_API_KEY'),
            'secret' => env('YODIE_API_SECRET'),
        ]
    ],
    'shared_secret' => env('SHARED_SECRET')
];
