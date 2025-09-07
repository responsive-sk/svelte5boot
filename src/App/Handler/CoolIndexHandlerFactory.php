<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class CoolIndexHandlerFactory
{
    public function __invoke(ContainerInterface $container): CoolIndexHandler
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new CoolIndexHandler($template);
    }
}
