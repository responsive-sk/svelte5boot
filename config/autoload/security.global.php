<?php

declare(strict_types=1);

return [
    'csp' => [
        'default-src' => ["'self'"],
        'script-src'  => ["'self'", "'unsafe-inline'", 'https://unpkg.com', 'http://localhost:5173'],
        'style-src'   => ["'self'", "'unsafe-inline'"], // Tailwind requires inline
        'img-src'     => ["'self'", 'data:', 'https://images.unsplash.com'],
        'connect-src' => ["'self'", 'http://localhost:5173'], // For Vite HMR
        'font-src'    => ["'self'"],
        'form-action' => ["'self'"],
        'frame-src'   => ["'none'"],
    ],
];
