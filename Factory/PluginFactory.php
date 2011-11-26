<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Factory;

use Sylius\Bundle\PluginsBundle\Model\PluginInterface;

class PluginFactory implements PluginFactoryInterface
{
    public function create(PluginInterface $plugin)
    {
        if (file_exists($autoloader = __DIR__ . '/../../../../../../sylius-sandbox/Resources/plugins/' . $plugin->getLogicalName() . '/autoload.php')) {
            require_once $autoloader;
        }
        
        $class = $plugin->getClass();
        return new $class;
    }
}
