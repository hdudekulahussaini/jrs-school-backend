<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default PHPFlasher Theme
    |--------------------------------------------------------------------------
    |
    | Set the default notification theme.
    | Google Material Design theme is set as the default theme.
    |
    */
    'default' => 'theme.google',

    /*
    |--------------------------------------------------------------------------
    | Themes Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for themes, including Google Material Design.
    |
    */
    'themes' => [
        'theme.google' => [
            'name' => 'google',
            'view' => 'admin.partials.flasher-material',
            'styles' => [],
            'scripts' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher@2.2.0/dist/flasher.min.js',
            ],
            'options' => [
                'timeout' => 5000,
                'position' => 'top-right',
                'direction' => 'top',
                'elevation' => '3',
                'ripple' => true,
                'progressBar' => true,
                'closeButton' => true,
            ],
        ],
        'flasher' => [
            'name' => 'flasher',
            'options' => [
                'timeout' => 5000,
                'position' => 'top-right',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-translate session flashes
    |--------------------------------------------------------------------------
    |
    | Automatically map standard Laravel flash messages ('success', 'error',
    | 'warning', 'info') to PHPFlasher notifications.
    |
    */
    'auto_render' => true,
    'flash_bag' => [
        'success' => ['success', 'profile_success', 'email_success', 'password_success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'email_info'],
        'info' => ['info', 'status', 'message'],
    ],
];
