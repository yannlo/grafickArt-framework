<?php

namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;

class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $path = $container->get("views.path");
        $loader  = new FilesystemLoader($path);
        $twig = new Environment($loader, []);
        if ($container -> has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig -> addExtension($extension);
            }
        }

        return new TwigRenderer($loader, $twig);
    }
}
