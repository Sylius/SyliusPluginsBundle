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
    public function __construct(PluginManagerInterface $pluginManager, CacheInterface $cache)
    {
        $this->pluginManager = $pluginManager;
        $this->cache = $cache;
    }
    
    /**
     * {@inheritdoc}
     */
    public function install(PluginInterface $plugin)
    {
        $plugin->incrementInstalledAt();
        $this->pluginManager->persistPlugin($plugin);
        
        $this->cache->remove('sylius_plugins.plugins');
    }
    
	/**
     * {@inheritdoc}
     */
    public function uninstall(PluginInterface $plugin)
    {     
        $this->pluginManager->removePlugin($plugin);
        
        $this->cache->remove('sylius_plugins.plugins');
    }
    
    /**
     * {@inheritdoc}
     */
    public function enable(PluginInterface $plugin)
    {
        $plugin->setEnabled(true);
        $this->pluginManager->persistPlugin($plugin);
        
        $this->cache->remove('sylius_plugins.plugins');
    }
    
   	/**
     * {@inheritdoc}
     */
    public function disable(PluginInterface $plugin)
    {
        $plugin->setEnabled(false);
        $this->pluginManager->persistPlugin($plugin);
        
        $this->cache->remove('sylius_plugins.plugins');
    }
    
    public function activate(PluginInterface $plugin)
    {
        $this->cache->set('sylius_plugins.active_plugin', $plugin->getLogicalName());
        
        $this->enable($plugin);
    }
}
