<?php

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouterTest extends TestCase
{

    public function setUp(): void
    {
        $this->router = new Router();
    }


    public function testGetMethod()
    {
        $request = new ServerRequest('GET',"/blog");
        $this -> router -> get("/blog", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "hello");
            }

        }, 'blog');

        $route = $this -> router -> match ($request);
        $this -> assertEquals('blog', $route-> getName());
        $this -> assertEquals('hello', (string) ($route ->getMiddleware() -> process($request, new class implements RequestHandlerInterface{
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new Response();
            }
        })) ->getBody() );
    }


    public function testGetMethodIfUrlDoesNotExist()
    {
        $request = new ServerRequest('GET',"/qvervqe");

        $this -> router -> get("/blog", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "hello");
            }

        }, 'blog');

        $route = $this -> router -> match ($request);

        $this -> assertNull($route);
    }


    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET',"/blog/mon-slug-8");
        $this -> router -> get("/blog", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "bqveefqevlk");
            }

        }, 'posts');

        $this -> router -> get("/blog/{slug:[a-z0-9\-]+}-{id:\d+}", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "hello");
            }

        }, 'post.show');

        $route = $this -> router -> match ($request);
        $this -> assertEquals('post.show', $route-> getName());
        $this -> assertEquals(["slug" => 'mon-slug',"id"=>"8"], $route->getParams());
    }


    public function testGetMethodWithInvalideParameters()
    {
        $request = new ServerRequest('GET',"/blog/mon_slug-8");

        $this -> router -> get("/blog/{slug:[a-z0-9\-]+}-{id:\d+}", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "hello");
            }

        }, 'post.show');

        $route = $this -> router -> match ($request);
        $this -> assertNull($route);
    }
    

    public function testGenerateUri()
    {
        $this -> router -> get("/blog", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "bqveefqevlk");
            }

        }, 'posts');

        $this -> router -> get("/blog/{slug:[a-z0-9\-]+}-{id:\d+}", new class implements MiddlewareInterface{

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {   
                return new Response(200, [], "hello");
            }

        }, 'post.show');

        $uri  = $this->router->generateUri('post.show', ['slug' => 'mon-article',"id"=>"18"]);

        $this -> assertEquals('/blog/mon-article-18',$uri);
    }
}
