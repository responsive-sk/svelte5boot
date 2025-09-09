<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CspMiddleware implements MiddlewareInterface
{
    public function __construct(
        private array $cspConfig
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $cspHeader = $this->buildCspHeader($this->cspConfig);

        return $response->withHeader('Content-Security-Policy', $cspHeader);
    }

    private function buildCspHeader(array $config): string
    {
        $directives = [];

        foreach ($config as $directive => $values) {
            if (is_array($values)) {
                $directives[] = $directive . ' ' . implode(' ', $values);
            } else {
                $directives[] = $directive . ' ' . $values;
            }
        }

        return implode('; ', $directives);
    }
}
