<?php

namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BlogModule
{
    private MiddlewareInterface $index;
    private MiddlewareInterface $show;


    public function __construct(Router $router)
    {
        $this->defineMiddleware();
        $router->get("/blog", $this -> index, "blog.index");
        $router->get("/blog/{slug:[a-z\-]+}", $this -> show, "blog.show");
    }

    private function defineMiddleware(): void
    {

        $this->index = new class implements MiddlewareInterface{

            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler
            ): ResponseInterface {
                $response = $handler->handle($request);
                $response ->withStatus(200);
                $response ->getBody()->write("<h1>Bienvenue sur le blog</h1>");
                return $response;
            }
        };

        $this->show = new class implements MiddlewareInterface{

            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler
            ): ResponseInterface {
                $response = $handler->handle($request);
                $response ->withStatus(200);
                $response ->getBody()->write("<h1>Page du produit " . $request->getAttribute("slug") . "</h1>") ;
                return $response;
            }
        };
    }
}
