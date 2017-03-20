<?php

namespace Bliss;

use ArrayAccess;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class Blade implements ArrayAccess
{
    /**
     * Blade view factory instance.
     * @var Factory
     */
    protected $viewFactory;

    /**
     * Default view variables.
     * @var array
     */
    protected $defaultVariables = [];

    /**
     * Create new Blade view.
     * @param array|string $paths Path(s) to templates directory (directories).
     * @param string $cachePath Path to cache directory.
     * @param Dispatcher|null $events
     */
    public function __construct($paths, $cachePath, Dispatcher $events = null)
    {
        $files = new Filesystem;

        $resolver = new EngineResolver;

        $resolver->register('php', function () {
            return new PhpEngine;
        });

        $resolver->register('blade', function () use ($files, $cachePath) {
            $compiler = new BladeCompiler($files, $cachePath);

            return new CompilerEngine($compiler);
        });

        $this->viewFactory = new Factory(
            $resolver,
            new FileViewFinder($files, (array) $paths),
            isset($events) ? $events : new Dispatcher
        );
    }

    /**
     * Render a template.
     * @param string $template Template filename.
     * @param array $data Associative array of template variables.
     * @return string
     */
    public function render($template, $data = [])
    {
        $data = array_merge($this->defaultVariables, $data);

        return $this->viewFactory->make($template, $data)->render();
    }

    /**
     * Does this collection have a given key?
     * @param string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->defaultVariables);
    }

    /**
     * Get collection item.
     * @param string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->defaultVariables[$key];
    }

    /**
     * Set collection item.
     * @param string $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->defaultVariables[$key] = $value;
    }

    /**
     * Remove item from collection.
     * @param string $key
     */
    public function offsetUnset($key)
    {
        unset($this->defaultVariables[$key]);
    }
}
