<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Packager;

use Sylius\Bundle\PluginsBundle\Model\PluginInterface;
use Symfony\Component\Finder\Finder;

/**
 * Plugin packs management.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PluginPackager
{
    /**
     * Directory where plugins are stored.
     * 
     * @var string
     */
    protected $packsDir;
    
    /**
     * @param string $packsDir
     */
    public function __construct($packsDir)
    {
        $this->packsDir = $packsDir;
    }
    
    /**
     * Returns all plugin packs that were not installed.
     * 
     * @param array $plugins
     */
    public function findPacks(array $plugins)
    {
        $finder = new Finder();
        $packsIterator = $finder->directories()->depth(0)->in($this->packsDir)->getIterator();
        
        $packs = array();
        $installedPluginsPaths = array();
        
        foreach ($plugins as $plugin) {
            if (!$plugin instanceof PluginInterface) {
                throw new InvalidArgumentException('Plugins supplied to packages must implement Sylius\Bundle\PluginsBundle\Model\PluginInterface');
            }
            
            $installedPluginsPaths[] = $this->packsDir . '/' . $plugin->getLogicalName();
        }
        
        foreach ($packsIterator as $path) {
            if (!in_array($path, $installedPluginsPaths)) {
                $packs[] = $this->createPack($path);
            }
        }
        
        return $packs;
    }
    
    /**
     * Returns plugin pack instance based on path.
     * 
     * @param string $path
     */
    public function createPack($path)
    {
        return new PluginPack($path);
    }
}