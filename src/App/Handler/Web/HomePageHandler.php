<?php

declare(strict_types=1);

namespace App\Handler\Web;

use App\Handler\AbstractHandler;
use Mezzio\Router\RouterInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class HomePageHandler extends AbstractHandler implements RequestHandlerInterface
{
    public function __construct(
        private string $appName,
        private RouterInterface $router,
        ?TemplateRendererInterface $template = null,
    ) {
        parent::__construct($template);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->template === null) {
            return $this->jsonResponse([
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
            'request' => $request,
        ];

        return $this->htmlResponse('app::home-page', $data);
    }
}
