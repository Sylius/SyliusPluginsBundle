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
 * Plugins manager.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class PluginManager implements PluginManagerInterface
{
    /**
     * Plugin class.
     * 
     * @var string
     */
    protected $class;
    
    /**
     * Constructor.
     * 
     * @var string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }
    
    /**
     * Returns FQCN of product.
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
