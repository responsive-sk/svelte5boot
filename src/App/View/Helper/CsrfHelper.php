<?php

namespace App\View\Helper;

use Mezzio\Csrf\CsrfMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class CsrfHelper
{
    public function __construct(
        private ServerRequestInterface $request
    ) {}

    public function getToken(): string
    {
        $guard = $this->request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        return $guard->generateToken();
    }

    public function getTokenInput(): string
    {
        return sprintf(
            '<input type="hidden" name="csrf" value="%s">',
            htmlspecialchars($this->getToken(), ENT_QUOTES, 'UTF-8')
        );
    }
}
