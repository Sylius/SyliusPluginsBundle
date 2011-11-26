<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle;

use Sylius\Bundle\PluginsBundle\Cache\FilesystemCache;
use Sylius\Bundle\PluginsBundle\Factory\PluginFactory;
use Sylius\Bundle\PluginsBundle\Injector\PluginInjector;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Plugins for your Symfony2 application.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusPluginsBundle extends Bundle
{
    private $kernel;
    
    public function __construct(KernelInterface $kernel, array &$bundles)
    {
        $this->kernel = $kernel;
        $injector = new PluginInjector(new PluginFactory(), new FilesystemCache($kernel->getCacheDir()));
        
        $injector->inject($bundles);
    }
}
