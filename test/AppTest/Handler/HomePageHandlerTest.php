<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\Web\HomePageHandler;
use App\Service\ResponseStrategy\ResponseStrategySelector;
use App\Service\ResponseStrategy\ApiResponseStrategy;
use App\Service\ResponseStrategy\FragmentResponseStrategy;
use App\Service\ResponseStrategy\PageResponseStrategy;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class HomePageHandlerTest extends TestCase
{
    /** @var ContainerInterface&MockObject */
    protected $container;

    /** @var RouterInterface&MockObject */
    protected $router;

    /** @var ResponseStrategySelector&MockObject */
    protected $responseStrategySelector;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->router    = $this->createMock(RouterInterface::class);
        $this->responseStrategySelector = $this->createMock(ResponseStrategySelector::class);
    }

    public function testReturnsResponseFromStrategySelector(): void
    {
        $expectedResponse = $this->createMock(ResponseInterface::class);

        $this->responseStrategySelector
            ->expects($this->once())
            ->method('select')
            ->willReturnCallback(function ($request) {
                $strategy = $this->createMock(PageResponseStrategy::class);
                $strategy->expects($this->once())
                    ->method('render')
                    ->willReturn($this->createMock(HtmlResponse::class));
                return $strategy;
            });

        $homePage = new HomePageHandler(
            $this->container::class,
            $this->router,
            $this->responseStrategySelector
        );

        $response = $homePage->handle(
            $this->createMock(ServerRequestInterface::class)
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
    }
}
