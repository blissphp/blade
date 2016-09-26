<?php

namespace Bliss;

use Bliss\Blade\View;

class Blade extends Plugin
{
    public function register($container)
    {
        $settings = $container['settings']['view'] ?: [];

        $container['view'] = function ($container) use ($settings) {
            $view = new View($settings['templatePaths'], $settings['cachePath']);
            $view['container'] = $container;

            return $view;
        };

        $container['response']->setView($container['view']);
    }
}
