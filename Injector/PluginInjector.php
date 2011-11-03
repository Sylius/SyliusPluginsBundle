<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Injector;

use Sylius\Bundle\PluginsBundle\HttpKernel\Factory\PluginFactoryInterface;

class PluginInjector
{
    protected $factory;
    protected $cache;
    
    public function __construct(PluginFactoryInterface $factory, CacheInterface $cache)
    {
        $this->factory = $factory;
        $this->cache = $cache;
    }
    
    public function inject(array $bundles)
    {
        $plugins = $this->cache->get('sylius_plugins');
        
        foreach ($plugins as $plugin) {
            $bundles[] = $this->factory->create($plugin);
        }
    }
}
