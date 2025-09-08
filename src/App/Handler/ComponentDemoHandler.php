<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ComponentDemoHandler implements RequestHandlerInterface
{
    public function __construct(private ?TemplateRendererInterface $template = null)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->template?->render('app::component-demo', [
            'message' => 'This HTML fragment is rendered server-side and can be swapped by HTMX.',
        ]) ?? '<div class="p-4 border rounded">Component demo fragment (template renderer unavailable)</div>';

        return new HtmlResponse($html);
    }
}
