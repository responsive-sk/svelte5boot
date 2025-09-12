<?php

declare(strict_types=1);

use Sirix\TwigViteExtension\Twig\ViteExtension;
use App\View\Twig\CsrfExtension;
use App\View\Twig\SvelteComponentExtension;
use Psr\Http\Message\ServerRequestInterface;

return [
    'dependencies' => [
        'factories' => [
            CsrfExtension::class => function ($container) {
                return new CsrfExtension(
                    $container->get(ServerRequestInterface::class)
                );
            },
            SvelteComponentExtension::class => function ($container) {
                return new SvelteComponentExtension();
            },
        ],
    ],
    'templates' => [
        'paths' => [
            'error'    => [dirname(__DIR__, 2) . '/templates/error'],
            '__main__' => [dirname(__DIR__, 2) . '/templates'],
        ],
    ],
    'twig'      => [
        'extensions' => [
            ViteExtension::class,
            CsrfExtension::class,
            SvelteComponentExtension::class,
        ],
    ],
];
