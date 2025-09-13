<?php

declare(strict_types=1);

namespace AppTest;

use Psr\Container\ContainerInterface;
use RuntimeException;
use App\Service\ResponseStrategy\ResponseStrategySelector;
use App\Service\ResponseStrategy\ApiResponseStrategy;
use App\Service\ResponseStrategy\FragmentResponseStrategy;
use App\Service\ResponseStrategy\PageResponseStrategy;
use Mezzio\Template\TemplateRendererInterface;

use function array_key_exists;
use function sprintf;

/**
 * A PSR Container stub. Useful for testing factories without excessive mocking
 */
final class InMemoryContainer implements ContainerInterface
{
    /** @var array<string, mixed> */
    public array $services = [];

    public function __construct()
    {
        // Register ResponseStrategySelector and dependencies for tests
        $this->services[ApiResponseStrategy::class] = new ApiResponseStrategy();
        $this->services[FragmentResponseStrategy::class] = new FragmentResponseStrategy();
        $this->services[PageResponseStrategy::class] = new PageResponseStrategy($this->createMockTemplateRenderer());
        $this->services[ResponseStrategySelector::class] = new ResponseStrategySelector(
            $this->services[ApiResponseStrategy::class],
            $this->services[FragmentResponseStrategy::class],
            $this->services[PageResponseStrategy::class]
        );
    }

    private function createMockTemplateRenderer(): TemplateRendererInterface
    {
        return new class implements TemplateRendererInterface {
            public function render(string $name, $params = []): string
            {
                return '';
            }
            public function addDefaultParam(string $templateName, string $paramName, $value): void {}
            public function hasTemplate(string $name): bool { return true; }
            public function addPath(string $path): void {}
            public function getPaths(): array { return []; }
        };
    }

    public function setService(string $name, mixed $service): void
    {
        $this->services[$name] = $service;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        if (! $this->has($id)) {
            throw new RuntimeException(sprintf('Service not found "%s"', $id));
        }

        return $this->services[$id];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->services);
    }
}
