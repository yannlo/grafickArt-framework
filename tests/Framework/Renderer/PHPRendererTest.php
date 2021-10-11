<?php

namespace Tests\Renderer\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Renderer\PHPRenderer;

class PHPRendererTest extends TestCase
{
    private PHPRenderer $renderer;

    public function setUp(): void
    {
        $this -> renderer = new PHPRenderer ( __DIR__ . '/views');
    }

    public function testRenderTheRightPath(): void
    {
        $this -> renderer ->addPath( __DIR__ . '/views','blog');
        $content = $this -> renderer ->  render('@blog/demo');
        $this -> assertEquals("salut les gens",$content);
    }

    public function testRenderTheDefaultPath(): void
    {
        $content = $this -> renderer ->  render('demo');
        $this -> assertEquals("salut les gens",$content);
    }

    public function testRenderWithParams(): void
    {
        $content = $this -> renderer ->  render('demoParams',["name" => "vin rouge"]);
        $this -> assertEquals("Article vin rouge",$content);
    }
    public function testGlobalParameter(): void
    {
        $this -> renderer -> addGlobal("name","vin rouge" );
        $content = $this -> renderer ->  render('demoParams');
        $this -> assertEquals("Article vin rouge",$content);
    }
}