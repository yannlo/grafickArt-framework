<?php

require "../vendor/autoload.php";

use Framework\App;
use Framework\Renderer;

use App\Blog\BlogModule;
use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;

$renderer = new Renderer();

$renderer -> addPath(dirname(__DIR__) . "/src/layouts");
$app = new App([
    BlogModule::class
], [
    "renderer" => $renderer
]);

$request  = ServerRequest::fromGlobals();

send($app->run($request));
