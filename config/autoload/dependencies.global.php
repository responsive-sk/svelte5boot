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
            \Mezzio\Handler\NotFoundHandler::class => \App\Handler\Web\NotFoundHandler::class,
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
            'App\Handler\Api\PingHandler' => App\Handler\Api\PingHandlerFactory::class,
            'App\Handler\Web\ComponentDemoHandler' => App\Handler\Web\ComponentDemoHandlerFactory::class,
            'App\Handler\Web\HeroHandler' => App\Handler\Web\HeroHandlerFactory::class,
            'App\Handler\Htmx\ContentHandler' => App\Handler\Htmx\ContentHandlerFactory::class,
            'App\Handler\Htmx\PartialApi' => App\Handler\Htmx\PartialApiFactory::class,
            'App\Handler\Web\TestFrontendHandler' => App\Handler\Web\TestFrontendHandlerFactory::class,
            'App\Handler\Web\NotFoundHandler' => App\Handler\Web\NotFoundHandlerFactory::class,
            'App\Handler\Web\HomePageHandler' => App\Handler\Web\HomePageHandlerFactory::class,
            'App\Handler\Web\CoolIndexHandler' => App\Handler\Web\CoolIndexHandlerFactory::class,
            'App\Handler\Web\TestCsrfHandler' => App\Handler\Web\TestCsrfHandlerFactory::class,
            'App\Repository\ProductRepositoryInterface' => function ($container) {
                return new \App\Repository\ProductRepository();
            },
            'App\Service\ProductService' => App\Service\ProductServiceFactory::class,
            'App\Middleware\CspMiddleware' => function ($container) {
                $config = $container->get('config');
                return new \App\Middleware\CspMiddleware($config['csp'] ?? []);
            },
            'Mezzio\Session\SessionMiddleware' => \Mezzio\Session\SessionMiddlewareFactory::class,
        ],
    ],
];
