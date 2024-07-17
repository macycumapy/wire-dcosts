<?php

declare(strict_types=1);

return [
    'name' => 'DCostsPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'DCosts',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#064E3B',
        'display' => 'standalone',
        'orientation' => 'any',
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
