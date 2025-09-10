<?php

declare(strict_types=1);

namespace App\Handler\Htmx;

use Psr\Container\ContainerInterface;

final class ContentHandlerFactory
{
    public function __invoke(ContainerInterface $container): ContentHandler
    {
        $template = $container->has(\Mezzio\Template\TemplateRendererInterface::class)
            ? $container->get(\Mezzio\Template\TemplateRendererInterface::class)
            : null;

        return new ContentHandler($template);
    }
}
