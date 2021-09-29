<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if ($uri !== "/" && $uri[-1] === "/") {
            return (new Response())
            ->withStatus(301)
            ->withHeader("Location", substr($uri, 0, -1));
        }
        if ($uri === "/blog") {
            return new Response(200, [], "<h1>Bienvenue sur le blog</h1>");
        }
        return new Response(404, [], "<h1>Error 404</h1>");
    }
}
