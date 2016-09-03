<?php

namespace Bliss\Blade;

use ArrayAccess;
use ArrayIterator;
use Philo\Blade\Blade;
use Illuminate\Events\Dispatcher;
use Psr\Http\Message\ResponseInterface;

class View implements ArrayAccess
{
    /**
     * Blade instance
     *
     * @var \Philo\Blade\Blade
     */
    protected $blade;

    /**
     * Default view variables
     *
     * @var array
     */
    protected $defaultVariables = [];

    /**
     * Create new Blade view
     *
     * @param array  $viewPaths
     * @param string $cachePath
     * @param Illuminate\Events\Dispatcher $events
     */
    public function __construct(array $viewPaths, $cachePath, Dispatcher $events = null)
    {
        $this->blade = new Blade($viewPaths, $cachePath, $events);
    }

    /**
     * Fetch rendered template
     *
     * @param  string $template Template pathname relative to templates directory
     * @param  array  $data     Associative array of template variables
     *
     * @return string
     */
    public function fetch($template, $data = [])
    {
        $data = array_merge($this->defaultVariables, $data);
        return $this->blade->view()->make($template, $data)->render();
    }

    /**
     * Output rendered template
     *
     * @param  ResponseInterface $response
     * @param  string $template Template pathname relative to templates directory
     * @param  array $data Associative array of template variables
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, $data = [])
    {
         $response->getBody()->write($this->fetch($template, $data));
         return $response;
    }

    /**
     * Return Blade instance
     *
     * @return \Philo\Blade\Blade
     */
    public function getBlade()
    {
        return $this->blade;
    }

    /**
     * Does this collection have a given key?
     *
     * @param  string $key The data key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->defaultVariables);
    }

    /**
     * Get collection item for key
     *
     * @param string $key The data key
     *
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
        return $this->defaultVariables[$key];
    }

    /**
     * Set collection item
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     */
    public function offsetSet($key, $value)
    {
        $this->defaultVariables[$key] = $value;
    }

    /**
     * Remove item from collection
     *
     * @param string $key The data key
     */
    public function offsetUnset($key)
    {
        unset($this->defaultVariables[$key]);
    }

    /**
     * Get number of items in collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->defaultVariables);
    }

    /**
     * Get collection iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->defaultVariables);
    }
}
