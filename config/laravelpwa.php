<?php

declare(strict_types=1);

return [
    'name' => 'DCostsPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'DCosts',
        'start_url' => '/',
        'background_color' => '#064E3B',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'status_bar' => 'black',
        'icons' => [],
        'shortcuts' => [
            [
                'name' => 'Отчет о затратах',
                'description' => 'Отчет о затратах',
                'url' => '/reports/outflows',
                'icons' => [
                    "src" => "/images/logo.png",
                    "purpose" => "any"
                ]
            ],
        ],
        'custom' => []
    ]
];
