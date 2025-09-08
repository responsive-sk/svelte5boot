<?php

declare(strict_types=1);

namespace App\Handler\Api;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ContentHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Data pre HTMX response
        $content = '<div class="p-4 bg-gray-100 text-gray-900 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Dynamicky načítaný obsah</h3>
            <p class="text-sm">Čas načítania: ' . date('Y-m-d H:i:s') . '</p>
            <p class="text-sm mt-2">Tento obsah bol načítaný cez HTMX!</p>
        </div>';

        // Vráti len HTML fragment
        $response = new Response();
        $response->getBody()->write($content);
        return $response->withHeader('Content-Type', 'text/html');
    }
}