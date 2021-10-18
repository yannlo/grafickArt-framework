<?php

require "../vendor/autoload.php";

use Framework\App;
use App\Blog\BlogModule;
use DI\ContainerBuilder;
use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\RendererInterface;

$modules = [
    BlogModule::class
];

$builder = new ContainerBuilder();

$builder -> addDefinitions(dirname(__DIR__) . '/config/config.php');

foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder -> addDefinitions($module::DEFINITIONS);
    }
}

$builder -> addDefinitions(dirname(__DIR__) . '/config.php');

$container =  $builder -> build();


$renderer = $container -> get(RendererInterface::class);

$app = new App($container, $modules);

$request  = ServerRequest::fromGlobals();

send($app->run($request));
