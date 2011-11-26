<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Manipulator;

use Symfony\Component\HttpKernel\Util\Filesystem;
use Sylius\Bundle\PluginsBundle\Cache\CacheInterface;
use Sylius\Bundle\PluginsBundle\Model\PluginManagerInterface;
use Sylius\Bundle\PluginsBundle\Model\PluginInterface;

/**
 * Plugin manipulator.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PluginManipulator implements PluginManipulatorInterface
{
    protected $pluginsDir;
    protected $cacheDir;
    protected $filesystem;
    
    /**
     * Plugin manager.
     * 
     * @var PluginManagerInterface
     */
    protected $pluginManager;
    
    /**
     * Cache.
     * 
     * @var CacheInterface
     */
    protected $cache;
    
    /**
     * Constructor.
     * 
     * @param PluginManagerInterface 	$pluginManager
     * @param SlugizerInterface 		$slugizer
     */
    public function __construct($pluginsDir, $cacheDir, Filesystem $filesystem, PluginManagerInterface $pluginManager, CacheInterface $cache)
    {
        $this->pluginsDir = $pluginsDir;
        $this->cacheDir = $cacheDir;
        $this->filesystem = $filesystem;
        $this->pluginManager = $pluginManager;
        $this->cache = $cache;
    }
    
    /**
     * {@inheritdoc}
     */
    public function install(PluginInterface $plugin)
    {
        $plugin->incrementInstalledAt();
        $plugin->setPath($this->pluginsDir . '/' . $plugin->getLogicalName());
        
        $this->pluginManager->persistPlugin($plugin);
    }
    
	/**
     * {@inheritdoc}
     */
    public function uninstall(PluginInterface $plugin)
    {     
        $this->pluginManager->removePlugin($plugin);
    }
    
    /**
     * {@inheritdoc}
     */
    public function enable(PluginInterface $plugin)
    {
        $plugin->setEnabled(true);
        $this->pluginManager->persistPlugin($plugin);
    }
    
   	/**
     * {@inheritdoc}
     */
    public function disable(PluginInterface $plugin)
    {
        $plugin->setEnabled(false);
        $this->pluginManager->persistPlugin($plugin);
    }
    
    public function refresh()
    {
        $cacheDir = $this->cacheDir;
        
        if (!is_writable($cacheDir)) {
            throw new \RuntimeException(sprintf('Unable to write in the "%s" directory.', $cacheDir));
        }
        
        $this->filesystem->remove($cacheDir);
        
        $plugins = $this->pluginManager->findPluginsBy(array('enabled' => true));
        $this->cache->set('sylius_plugins.installed', $plugins);
    }
}
