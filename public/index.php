<?php

require "../vendor/autoload.php";

use Framework\App;
use App\Blog\BlogModule;

use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;

$app = new App([
    BlogModule::class
]);

$request  = ServerRequest::fromGlobals();

send($app->run($request));
