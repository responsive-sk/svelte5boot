<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CoolIndexHandler implements RequestHandlerInterface
{
    public function __construct(private ?TemplateRendererInterface $template = null)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->template?->render('app::cool-index', [
            'title'       => 'Mezzio + Svelte | Modern PHP Frontend',
            'description' => 'A modern, SEO-friendly landing page powered by Mezzio, Svelte, HTMX and Tailwind CSS.',
            'canonical'   => '/cool',
        ]) ?? 'Template renderer not available';

        return new HtmlResponse($html);
    }
}
