<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class App implements RequestHandlerInterface
{
    private array $modules;

    private Router $router;

    public function __construct(array $modules = [], array $depndencies = [])
    {
        $this->router = new Router();

        if (array_key_exists("renderer", $depndencies)) {
            $depndencies["renderer"] -> addGlobal('router', $this->router);
        }

        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router, $depndencies["renderer"]);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if ($uri !== "/" && $uri[-1] === "/") {
            return (new Response())
            ->withStatus(301)
            ->withHeader("Location", substr($uri, 0, -1));
        }

        $route = $this->router->match($request);
        if (is_null($route)) {
            return new Response(404, [], "<h1>Error 404</h1>");
        }

        $params = $route->getParams();

        $request = array_reduce(array_keys($params), function ($request, $keyParam) use ($params) {
            return $request -> withAttribute($keyParam, $params[$keyParam]);
        }, $request);
        $response = $route -> getMiddleware() -> process($request, $this);
        if ($response instanceof ResponseInterface) {
            return $response;
        }

        throw new \exception("The response is not instance of ResponseInterface");
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}
