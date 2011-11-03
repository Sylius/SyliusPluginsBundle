<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Model;

/**
 * Plugin manager interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PluginManagerInterface
{
    function createPlugin();
    function persistPlugin(PluginInterface $plugin);
    function removePlugin(PluginInterface $plugin);
    function findPlugin($id);
    function findPluginBy(array $criteria);
    function findPlugins();
    function findPluginsBy(array $criteria);
    function getClass();
}
