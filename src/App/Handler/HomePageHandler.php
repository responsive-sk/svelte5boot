<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class HomePageHandler implements RequestHandlerInterface
{
    public function __construct(
        private string $appName,
        private RouterInterface $router,
        private ?TemplateRendererInterface $template = null,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->template === null) {
            return new JsonResponse([
                'appName'  => $this->appName,
                'greeting' => 'HTMX PSR-15',
            ]);
        }

        // Capture current route result if available for template context
        /** @var RouteResult|null $currentRoute */
        $currentRoute = $request->getAttribute(RouteResult::class);
        /** @var string|null $routeName */
        $routeName    = $currentRoute instanceof RouteResult ? $currentRoute->getMatchedRouteName() : null;

        // Server-side data pre Twig
        $data = [
            'title' => 'Domovska stránka',
            'content' => 'Vitajte v našej aplikácii',
            'appName' => $this->appName,
            'greeting' => 'HTMX PSR-15',
            'route_name' => $routeName,
            // reference router so Psalm does not flag it as unused
            'router_class' => $this->router::class,
        ];

        // Vráti plnohodnotné HTML
        return new HtmlResponse(
            $this->template->render('app::home-page', $data)
        );
    }
}
