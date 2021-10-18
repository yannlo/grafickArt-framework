<?php

use function DI\create;
use function DI\factory;
use function DI\get;

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Router\RouterTwigExtension;

return [
    'views.path' => dirname(__DIR__) . "/src/layouts",
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    RendererInterface:: class => factory(TwigRendererFactory::class),
    Router::class => create()
];