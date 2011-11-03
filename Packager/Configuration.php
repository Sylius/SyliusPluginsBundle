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

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Plugin pack configuration.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('plugin');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('version')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('description')->defaultValue('...')->end()
            ->end();
            
        return $treeBuilder;
    }
}
