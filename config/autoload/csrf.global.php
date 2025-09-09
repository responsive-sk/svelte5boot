<?php

declare(strict_types=1);

use Laminas\Csrf\SessionGuard;

return [
    'csrf' => [
        'guard' => SessionGuard::class,
        'guard_options' => [
            'timeout' => 300, // 5 minutes
            'samesite' => 'Lax',
        ],
        'token_name' => 'csrf.global.php',
    ],
];
