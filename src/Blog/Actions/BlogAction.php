<?php

namespace App\Blog\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BlogAction implements MiddlewareInterface
{

    public function __construct(private RendererInterface $renderer)
    {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);
        $response ->withStatus(200);
        $slug = $request -> getAttribute('slug');

        if (!is_null($slug)) {
            $content = $this -> show($slug);
        } else {
            $content = $this -> index();
        }

        $response ->getBody()->write($content);
        return $response;
    }

    private function index(): string
    {
        return $this->renderer->render("@Blog/index");
    }

    private function show(string $slug): string
    {
        return $this->renderer->render("@Blog/show", [
            "slug" => $slug
        ]);
    }
}
