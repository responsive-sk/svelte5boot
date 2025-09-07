<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class ComponentDemoHandlerFactory
{
    public function __invoke(ContainerInterface $container): ComponentDemoHandler
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new ComponentDemoHandler($template);
    }
}
