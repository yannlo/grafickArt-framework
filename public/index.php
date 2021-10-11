<?php

require "../vendor/autoload.php";

use Framework\App;
use Twig\Environment;
use App\Blog\BlogModule;
use function Http\Response\send;
use Twig\Loader\FilesystemLoader;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\TwigRenderer;

$renderer = new TwigRenderer(dirname(__DIR__) . "/src/layouts");

$app = new App([
    BlogModule::class
], [
    "renderer" => $renderer
]);

$request  = ServerRequest::fromGlobals();

send($app->run($request));