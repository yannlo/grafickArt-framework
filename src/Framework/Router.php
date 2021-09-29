<?php

namespace Framework;

use Framework\Router\Route;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route as MezzioRoute;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * register and matched route
 */
class Router
{
    private FastRouteRouter $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * get
     *
     * @param  string $path
     * @param  MiddlewareInterface $middleware
     * @param  string $name
     * @return void
     */
    public function get(string $path, MiddlewareInterface $middleware, string $name): void
    {
        $this -> router->addRoute(new MezzioRoute(path: $path, middleware: $middleware, methods: ['GET'], name: $name));
    }

    /**
     * match
     *
     * @param  ServerRequestInterface $request
     * @return Route
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedRoute()->getMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    public function generateUri(string $name, array $params): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        return $uri;
    }
}
