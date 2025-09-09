<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * laminas-router route configuration
 *
 * @see https://docs.laminas.dev/laminas-router/
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->get('/api/component-demo', App\Handler\ComponentDemoHandler::class, 'api.component-demo');
    $app->get('/api/latest-content', App\Handler\Api\ContentHandler::class, 'api.latest-content');
    $app->get('/api/partial-content', App\Handler\Api\ContentHandler::class, 'api.partial-content');
    $app->get('/hero', App\Handler\HeroHandler::class, 'hero');
    $app->get('/cool', App\Handler\CoolIndexHandler::class, 'cool');
    $app->get('/test-frontend', App\Handler\TestFrontendHandler::class, 'test-frontend');
    $app->post('/api/test-csrf', App\Handler\TestCsrfHandler::class, 'api.test-csrf');
};
