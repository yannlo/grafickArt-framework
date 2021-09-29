<?php

namespace Tests\Framework;

use Framework\App;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;


class Apptest extends TestCase
{
    public function testRedirectionTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest("GET","/afeavav/");
        $response = $app->run($request);
        $this->assertContains("/afeavav", $response -> getHeader("Location"));
        $this -> assertEquals(301, $response -> getStatusCode());
    }

    public function testBlog()
    {
        $app = new App();
        $request = new ServerRequest("GET","/blog");
        $response = $app->run($request);
        $this->assertEquals("<h1>Bienvenue sur le blog</h1>",(string)$response -> getBody() );
        $this -> assertEquals(200, $response -> getStatusCode());

    }


    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest("GET","/vqvrre");
        $response = $app->run($request);
        $this->assertEquals("<h1>Error 404</h1>",(string) $response -> getBody() );
        $this -> assertEquals(404, $response -> getStatusCode());

    }
}