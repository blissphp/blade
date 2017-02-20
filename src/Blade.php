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
     * BladeView constructor.
     * @param array|string $viewPaths
     * @param string $cachePath
     * @param Dispatcher|null $events
     */
    public function __construct($viewPaths, $cachePath, Dispatcher $events = null)
    {
        $files = new Filesystem;

        $resolver = new EngineResolver;

        $resolver->register('php', function() {
            return new PhpEngine;
        });

        $resolver->register('blade', function() use ($files, $cachePath) {
            $compiler = new BladeCompiler($files, $cachePath);

            return new CompilerEngine($compiler);
        });

        $this->viewFactory = new Factory(
            $resolver,
            new FileViewFinder($files, (array) $viewPaths),
            isset($events) ? $events : new Dispatcher
        );
    }

    /**
     * Render template.
     * @param string $template Template pathname relative to templates directory
     * @param array $data Associative array of template variables
     * @return string
     */
    public function render($template, $data = [])
    {
        $data = array_merge($this->defaultVariables, $data);

        return $this->viewFactory->make($template, $data)->render();
    }

    /**
     * Does this collection have a given key?
     * @param string $key The data key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->defaultVariables);
    }

    /**
     * Get collection item for key.
     * @param string $key The data key
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
        return $this->defaultVariables[$key];
    }

    /**
     * Set collection item.
     * @param string $key The data key
     * @param mixed $value The data value
     */
    public function offsetSet($key, $value)
    {
        $this->defaultVariables[$key] = $value;
    }

    /**
     * Remove item from collection.
     * @param string $key The data key
     */
    public function offsetUnset($key)
    {
        unset($this->defaultVariables[$key]);
    }
}
