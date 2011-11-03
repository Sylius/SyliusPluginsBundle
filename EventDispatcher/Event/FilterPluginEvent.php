<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;
use Sylius\Bundle\PluginsBundle\Model\PluginInterface;

/**
 * Plugin filter event.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FilterPluginEvent extends Event
{
    /**
     * Plugin.
     * 
     * @var PluginInterface
     */
    protected $plugin;
    
    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }
    
    public function getPlugin()
    {
        return $this->plugin;
    }
}
