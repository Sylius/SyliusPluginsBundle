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

use Symfony\Component\Config\Definition\Processor;

use Sylius\Bundle\PluginsBundle\Model\PluginInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Plugin pack.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
final class PluginPack
{
    private $path;
    private $name;
    private $configuration;
    private $rootDir;
    
    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('Plugin file does not exist. Looked into... "%s".', $path));
        }
        
        $this->path = $path;
        $this->name = basename($path);
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function getEncodedPath()
    {
        return base64_encode($this->path);
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getConfiguration()
    {   
        if (null == $this->configuration) {
            
            if (!file_exists($configFile = $this->getPath() . '/plugin.yml')) {
                throw new RuntimeException(sprintf('The plugin configuration file "%s" does not exist.', $configFile));
            }

            $processor = new Processor();
            $this->configuration = $processor->processConfiguration(new Configuration, Yaml::parse(file_get_contents($configFile)));
        }
        
        return $this->configuration;
    }
    
    public function buildPlugin(PluginInterface $plugin)
    {
        $plugin->loadConfiguration($this->getConfiguration());
        $plugin->setLogicalName($this->getName());
        
        return $plugin;
    }
}
