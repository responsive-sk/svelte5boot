<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Template\TemplateRendererInterface;

final readonly class HomePageHandler implements RequestHandlerInterface
{
    public function __construct(
        private string $appName,
        private \Mezzio\Router\RouterInterface $router,
        private ?TemplateRendererInterface $template = null,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = new \Laminas\Diactoros\Response\HtmlResponse(
            $this->template?->render('app::home-page', [
                'appName' => $this->appName,
                'greeting' => 'HTMX PSR-15',
            ]) ?? 'Template renderer not available'
        );
        return $response;
    }
}
