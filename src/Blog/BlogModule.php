<?php

namespace App\Blog;

use Framework\Router;
use Framework\Renderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BlogModule
{
    private Renderer $renderer;
    private MiddlewareInterface $index;
    private MiddlewareInterface $show;


    public function __construct(Router $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer -> addPath(__DIR__ . "/views", "Blog");
        $this->defineMiddleware();
        $router->get("/blog", $this -> index, "blog.index");
        $router->get("/blog/{slug:[a-z\-0-9]+}", $this -> show, "blog.show");
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
                $content = $this->renderer->render("@Blog/index");
                $response ->getBody()->write($content);
                return $response;
            }
        };

        $this->show = new class implements MiddlewareInterface{

            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler
            ): ResponseInterface {
                $response = $handler->handle($request);
                $content = $this->renderer->render("@Blog/show", [
                    "slug" => $request -> getAttribute('slug')
                ]);
                $response ->getBody()->write($content);
                return $response;
            }
        };

        $this->index -> renderer = $this ->renderer;
        $this->show -> renderer = $this ->renderer;
    }
}
