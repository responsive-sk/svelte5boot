<?php

declare(strict_types=1);

return [
    'csp' => [
        'default-src' => ["'self'"],
        'script-src'  => ["'self'", 'https://unpkg.com'],
        'style-src'   => ["'self'", "'unsafe-inline'"], // Tailwind requires inline
        'img-src'     => ["'self'", 'data:'],
    ],
];
