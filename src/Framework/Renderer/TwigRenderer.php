<?php

namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    private FilesystemLoader $loader;
    private Environment $twig; 

    public function __construct(string $path)
    {
        $this -> loader  = new FilesystemLoader($path);
        $this -> twig = new Environment($this -> loader,[]);

    }


    public function addPath(string $path, ?string $namespace = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    public function addGlobal(string $key, mixed $value): void
    {
        $this->twig->addGlobal($key, $value);
    }

    public function render(string $view, array $params = []): string
    {
        return $this -> twig -> render ($view.".twig",$params);
    }
}