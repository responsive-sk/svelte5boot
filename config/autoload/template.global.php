<?php

declare(strict_types=1);

use Sirix\TwigViteExtension\Twig\ViteExtension;

return [
    'templates' => [
        'paths' => [
            'error'    => [dirname(__DIR__, 2) . '/templates/error'],
            '__main__' => [dirname(__DIR__, 2) . '/templates'],
        ],
    ],
    'twig'      => [
        'extensions' => [
            ViteExtension::class,
        ],
    ],
];
