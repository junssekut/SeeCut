<?php

declare(strict_types=1);

use Flasher\Prime\Configuration;

/*
 * Default PHPFlasher configuration for Laravel.
 *
 * This configuration file defines the default settings for PHPFlasher when
 * used within a Laravel application. It uses the Configuration class from
 * the core PHPFlasher library to establish type-safe configuration.
 *
 * @return array PHPFlasher configuration
 */
return Configuration::from([
    // Default notification library (e.g., 'flasher', 'toastr', 'noty', 'notyf', 'sweetalert')
    'default' => 'toastr',
    'plugins' => [
        'toastr' => [
            'scripts' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/toastr.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => [
                '/vendor/flasher/toastr.min.css',
            ],
            'options' => [
                'closeButton' => true,
                'progressBar' => true,
                'positionClass' => 'toast-bottom-right',
                'timeOut' => 5000,
                'extendedTimeOut' => 1000,
                'preventDuplicates' => false,
                'newestOnTop' => true,
                'showEasing' => 'swing',
                'hideEasing' => 'linear',
                'showMethod' => 'fadeIn',
                'hideMethod' => 'fadeOut',
            ],
        ],
    ],

    // Path to the main PHPFlasher JavaScript file
    'main_script' => '/vendor/flasher/flasher.min.js',

    // List of CSS files to style your notifications
    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    // Set global options for all notifications (optional)
    'options' => [
        'timeout' => 3000, // Time in milliseconds before the notification disappears
        'position' => 'bottom-right', // Where the notification appears on the screen
    ],

    // Automatically inject JavaScript and CSS assets into your HTML pages
    'inject_assets' => true,

    // Enable message translation using Laravel's translation service
    'translate' => true,

    // URL patterns to exclude from asset injection and flash_bag conversion
    'excluded_paths' => [],

    // Map Laravel flash message keys to notification types
    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    // Set criteria to filter which notifications are displayed (optional)
    // 'filter' => [
    //     'limit' => 5, // Maximum number of notifications to show at once
    // ],

    // Define notification presets to simplify notification creation (optional)
    // 'presets' => [
    //     'entity_saved' => [
    //         'type' => 'success',
    //         'title' => 'Entity saved',
    //         'message' => 'Entity saved successfully',
    //     ],
    // ],
]);