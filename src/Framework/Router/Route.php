<?php

namespace Framework\Router;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Class Route
 * Represent a matched route
 */
class Route
{
    public function __construct(
        private string $name,
        private MiddlewareInterface $middleware,
        private array $parameters
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMiddleware(): MiddlewareInterface
    {
        return $this->middleware;
    }

    /**
     * get url list parameters
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
