<?php

declare(strict_types=1);

namespace App\Handler\Web;

use App\Handler\AbstractHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function time;

final readonly class PingHandler extends AbstractHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->jsonResponse(['ack' => time()]);
    }
}
