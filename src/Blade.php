<?php

namespace Bliss;

use Bliss\Views\Blade as BladeView;

class Blade extends Plugin
{
    protected $serviceName = 'blade';

    public function enable($container, $serviceName = null, $options = [])
    {
        $serviceName = $serviceName ?: 'blade';

        $container[$serviceName] = function ($c) {
            $blade = new BladeView($options['viewPaths'], $options['cachePath']);
            $blade['flash'] = $c->flash;

            return $blade;
        }

        $container->response->setView($container->$serviceName);
    }
}
