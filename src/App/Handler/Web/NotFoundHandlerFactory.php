<?php

declare(strict_types=1);

namespace App\Handler\Web;

use Psr\Container\ContainerInterface;
use Mezzio\Template\TemplateRendererInterface;

class NotFoundHandlerFactory
{
    public function __invoke(ContainerInterface $container): NotFoundHandler
    {
        return new NotFoundHandler(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
