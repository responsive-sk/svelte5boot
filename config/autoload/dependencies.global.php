<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
            \Mezzio\Handler\NotFoundHandler::class => \App\Handler\NotFoundHandler::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            'App\Middleware\CacheMiddleware' => App\Middleware\CacheMiddleware::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            'server_request_factory' => ServerRequestFactory::class,
            'App\Handler\ComponentDemoHandler' => App\Handler\ComponentDemoHandlerFactory::class,
            'App\Handler\HeroHandler' => App\Handler\HeroHandlerFactory::class,
            'App\Handler\Api\ContentHandler' => App\Handler\Api\ContentHandlerFactory::class,
            'App\Handler\TestFrontendHandler' => App\Handler\TestFrontendHandlerFactory::class,
            'App\Handler\NotFoundHandler' => App\Handler\NotFoundHandlerFactory::class,
            'App\Middleware\CspMiddleware' => function ($container) {
                $config = $container->get('config');
                return new \App\Middleware\CspMiddleware($config['csp'] ?? []);
            },
            'Mezzio\Session\SessionMiddleware' => \Mezzio\Session\SessionMiddlewareFactory::class,
        ],
    ],
];
