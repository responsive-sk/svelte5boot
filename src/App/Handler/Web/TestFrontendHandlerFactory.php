<?php

declare(strict_types=1);

namespace App\Handler\Web;

use Psr\Container\ContainerInterface;
use Mezzio\Template\TemplateRendererInterface;

class TestFrontendHandlerFactory
{
    public function __invoke(ContainerInterface $container): TestFrontendHandler
    {
        return new TestFrontendHandler(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
