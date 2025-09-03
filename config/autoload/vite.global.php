<?php

declare(strict_types=1);

use function Sirix\Config\env;

return [
    'vite' => [
        'options' => [
            'is_dev_mode'      => env('IS_DEV_MODE', true),
            'vite_build_dir'   => 'public/build',
            'vite_public_base' => 'build',
            'dev_server'       => 'http://localhost:5173',
        ],
    ],
];
