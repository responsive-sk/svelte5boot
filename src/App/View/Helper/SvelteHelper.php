<?php

declare(strict_types=1);

namespace App\View\Helper;

class SvelteHelper
{
    public function __construct()
    {}

    /** @param array<string, mixed> $additionalData */
    public function hydrationData(array $additionalData = []): string
    {
        $data = array_merge([
            'csrf' => '', // TODO: Fix CsrfMiddleware::getToken() - method not found
            'timestamp' => time(),
        ], $additionalData);

        return sprintf(
            '<script>window.__APP_DATA__ = %s;</script>',
            json_encode($data)
        );
    }

    /** @param array<string, mixed> $props */
    public function island(string $component, array $props = []): string
    {
        return sprintf(
            '<div data-island="%s" data-props="%s"></div>',
            $component,
            htmlspecialchars((string) json_encode($props), ENT_QUOTES, 'UTF-8')
        );
    }
}
