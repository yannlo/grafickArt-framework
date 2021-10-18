<?php

namespace App\Blog;

use Framework\Module;
use Framework\Router;
use App\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;

class BlogModule extends Module
{

    public const DEFINITIONS = __DIR__ . '/config.php';
    public const MIGRATIONS = __DIR__ . '/db/migrations';
    public const SEEDS =  __DIR__ . '/db/seeds';


    public function __construct(Router $router, RendererInterface $renderer, string $prefix)
    {

        $renderer -> addPath(__DIR__ . "/views", "Blog");
        $router->get($prefix, new BlogAction($renderer), "blog.index");
        $router->get($prefix . "/{slug:[a-z\-0-9]+}", new BlogAction($renderer), "blog.show");
    }
}
