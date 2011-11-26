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

use Sylius\Bundle\PluginsBundle\Model\PluginInterface;

/**
 * Plugin manipulator interface.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PluginManipulatorInterface
{
    /**
     * Creates a plugin.
     * 
     * @param PluginInterface $plugin
     */
    function install(PluginInterface $plugin);
    
    /**
     * Deletes a plugin.
     * 
     * @param PluginInterface $plugin
     */
    function uninstall(PluginInterface $plugin);
    
    /**
     * Enable a plugin.
     * 
     * @param PluginInterface $plugin
     */
    function enable(PluginInterface $plugin);
    
    /**
     * Disable a plugin.
     * 
     * @param PluginInterface $plugin
     */
    function disable(PluginInterface $plugin);
    
    /**
     * Refreshes installed plugins cache.
     */
    function refresh();
}
