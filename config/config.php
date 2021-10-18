<?php

use function DI\create;
use function DI\factory;
use function DI\get;

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Router\RouterTwigExtension;

return [
    // database configuration :
    "database.host" => "localhost",
    "database.username" => "root",
    "database.password" => "",
    "database.name" => "mon_site",


    // view default config :
    'views.path' => dirname(__DIR__) . "/src/layouts",
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],

    // basic class 
    RendererInterface:: class => factory(TwigRendererFactory::class),
    Router::class => create()
];