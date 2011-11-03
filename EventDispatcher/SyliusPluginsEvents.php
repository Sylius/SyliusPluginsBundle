<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\EventDispatcher;

/**
 * Events.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
final class SyliusPluginsEvents
{
    const PLUGIN_ENABLE      = 'sylius_plugins.event.plugin.enable';
    const PLUGIN_DISABLE     = 'sylius_plugins.event.plugin.disable';
    const PLUGIN_INSTALL     = 'sylius_plugins.event.plugin.install';
    const PLUGIN_UNINSTALL   = 'sylius_plugins.event.plugin.uninstall';
}
