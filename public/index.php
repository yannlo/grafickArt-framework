<?php

require "../vendor/autoload.php";

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

$app = new App();
$request  = ServerRequest::fromGlobals();

send($app->run($request));
