<?php

declare(strict_types=1);

namespace App\Handler\Htmx;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class ContentHandlerFactory
{
    public function __invoke(ContainerInterface $container): ContentHandler
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        \assert($template === null || $template instanceof TemplateRendererInterface);

        return new ContentHandler($template);
    }
}
