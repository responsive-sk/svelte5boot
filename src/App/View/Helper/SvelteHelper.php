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

    /** @param array<string, mixed> $props */
    public function renderComponent(string $name, array $props = [], ?string $html = null): string
    {
        $jsonProps = htmlspecialchars(json_encode($props, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}', ENT_QUOTES);

        return sprintf(
            '<div data-component="%s" data-props="%s">%s</div>',
            htmlspecialchars($name, ENT_QUOTES),
            $jsonProps,
            $html ?? ''
        );
    }
}
