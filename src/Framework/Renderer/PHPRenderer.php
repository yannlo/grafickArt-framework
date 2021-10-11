<?php

namespace Framework\Renderer;

/**
 * Renderer
 */
class PHPRenderer implements RendererInterface
{

    private array $paths;
    private array $globals = [];


    const DEFAULT_NAMESPACE = '__DEFAULT_NAME_';

    public function __construct(?string $defaultPath = null)
    {
        if(!is_null($defaultPath)) {
            $this -> addPath($defaultPath);
        }
    }

    /**
     * addPath
     *
     * Permite to add path to load view
     *
     * @param  string $path
     * @param  null|string $namespace
     * @return void
     */
    public function addPath(string $path, ?string $namespace = null): void
    {

        if (!is_null($namespace)) {
            $this->paths[$namespace] = $path;
            return;
        }

        $this->paths[self::DEFAULT_NAMESPACE] = $path;
    }

    /**
     * render
     *
     * permit to render views
     *
     * you can to get good path with the namespace
     *
     * $this->render(@namespace/view);
     *
     * $this->render(@view);
     * @param  string $view
     * @param  array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        if ($this-> hasNamespace($view)) {
            $path = $this -> replaceNamespace($view);
            ;
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view;
        }
        $path .= ".php";
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
     * addGlobal
     *
     * permite to add global variables in all views
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void
    {
        $this -> globals[$key] = $value;
    }

    /**
     * hasNamespace
     *
     * @param  string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === "@";
    }

    /**
     * getNamespace
     *
     * @param  string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    /**
     * replaceNamespace
     *
     * @param  string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this -> getNamespace($view);
        return str_replace("@" . $namespace, $this->paths[$namespace], $view);
    }
}
