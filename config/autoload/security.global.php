<?php

declare(strict_types=1);

return [
    'csp' => [
        'default-src' => ["'self'"],
        'script-src'  => ["'self'", 'https://unpkg.com', 'http://localhost:5173'],
        'style-src'   => ["'self'", "'unsafe-inline'"], // Tailwind requires inline
        'img-src'     => ["'self'", 'data:'],
        'connect-src' => ["'self'", 'http://localhost:5173'], // For Vite HMR
    ],
];
