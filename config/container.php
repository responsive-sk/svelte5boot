<?php

declare(strict_types=1);

use Laminas\ServiceManager\ServiceManager;
use App\Service\ResponseStrategy\ApiResponseStrategy;
use App\Service\ResponseStrategy\FragmentResponseStrategy;
use App\Service\ResponseStrategy\PageResponseStrategy;
use App\Service\ResponseStrategy\ResponseStrategySelector;

// Load configuration
$config = require __DIR__ . '/config.php';

$dependencies                       = $config['dependencies'];
$dependencies['services']['config'] = $config;

// Merge invokables from App\ConfigProvider if present
if (isset($config['dependencies']['invokables'])) {
    if (!isset($dependencies['invokables'])) {
        $dependencies['invokables'] = [];
    }
    $dependencies['invokables'] = array_merge(
        $dependencies['invokables'],
        $config['dependencies']['invokables']
    );
}

$dependencies['factories'][ApiResponseStrategy::class] = function () {
    return new ApiResponseStrategy();
};

$dependencies['factories'][FragmentResponseStrategy::class] = function () {
    return new FragmentResponseStrategy();
};

use Mezzio\Template\TemplateRendererInterface;

$dependencies['factories'][PageResponseStrategy::class] = function ($container) {
    return new PageResponseStrategy($container->get(TemplateRendererInterface::class));
};

$dependencies['factories'][ResponseStrategySelector::class] = function ($container) {
    return new ResponseStrategySelector(
        $container->get(ApiResponseStrategy::class),
        $container->get(FragmentResponseStrategy::class),
        $container->get(PageResponseStrategy::class),
    );
};

// Build container
return new ServiceManager($dependencies);
