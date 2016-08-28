<?php

namespace Bliss;

class Blade extends Plugin
{
    public function enable($container, $serviceName, $options)
    {
        $serviceName = $serviceName ?: 'blade';

        $container[$serviceName] = function ($c) use ($options) {
            $blade = new BladeView($options['viewPaths'], $options['cachePath']);

            $blade['flash'] = $c['flash']; // ???

            return $blade;
        };

        $container['response']->setView($container[$serviceName]);
    }
}
