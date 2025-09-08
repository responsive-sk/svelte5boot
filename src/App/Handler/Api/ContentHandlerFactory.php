<?php

declare(strict_types=1);

namespace App\Handler\Api;

use Psr\Container\ContainerInterface;

final class ContentHandlerFactory
{
    public function __invoke(ContainerInterface $container): ContentHandler
    {
        return new ContentHandler();
    }
}