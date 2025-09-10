<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\AbstractHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AbstractHandlerCriticalTest extends TestCase
{
    public function testHtmlResponseWithTemplate(): void
    {
        // Create a stub for the TemplateRendererInterface
        $templateRenderer = $this->createStub(TemplateRendererInterface::class);
        $templateRenderer->method('render')->willReturn('<html>Rendered Template</html>');

        // Create a concrete readonly class extending AbstractHandler for testing
        $handler = new readonly class($templateRenderer) extends AbstractHandler {
            /** @param array<string, mixed> $data */
            public function exposeHtmlResponse(string $template, array $data = []): ResponseInterface
            {
                return $this->htmlResponse($template, $data);
            }
        };

        $response = $handler->exposeHtmlResponse('template-name', ['key' => 'value']);
        $this->assertInstanceOf(HtmlResponse::class, $response);
        $this->assertStringContainsString('Rendered Template', (string) $response->getBody());
    }

    public function testHtmlResponseWithoutTemplate(): void
    {
        // Create handler without template renderer
        $handlerWithoutTemplate = new readonly class(null) extends AbstractHandler {
            /** @param array<string, mixed> $data */
            public function exposeHtmlResponse(string $template, array $data = []): ResponseInterface
            {
                return $this->htmlResponse($template, $data);
            }
        };

        $response = $handlerWithoutTemplate->exposeHtmlResponse('template-name', ['key' => 'value']);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertStringContainsString('"key":"value"', (string) $response->getBody());
    }

    public function testJsonResponse(): void
    {
        $handler = new readonly class(null) extends AbstractHandler {
            /** @param array<string, mixed> $data */
            public function exposeJsonResponse(array $data): ResponseInterface
            {
                return $this->jsonResponse($data);
            }
        };

        $data = ['foo' => 'bar'];
        $response = $handler->exposeJsonResponse($data);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertStringContainsString('"foo":"bar"', (string) $response->getBody());
    }

    public function testHtmxFragment(): void
    {
        $handler = new readonly class(null) extends AbstractHandler {
            public function exposeHtmxFragment(string $html): ResponseInterface
            {
                return $this->htmxFragment($html);
            }
        };

        $html = '<div>Test HTML</div>';
        $response = $handler->exposeHtmxFragment($html);
        $this->assertEquals('text/html', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString($html, (string) $response->getBody());
    }
}
