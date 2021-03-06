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

interface PluginInterface
{  
    function getId();
    function getName();
    function setName($name);
    function getClass();
    function setClass($class);
    function getPath();
    function setPath($path);
    function getLogicalName();
    function setLogicalName($logicalName);
    function getVersion();
    function setVersion($version);
    function getDescription();
    function setDescription($description);
    function isEnabled();
    function setEnabled($enabled);
    function getInstalledAt();  
    function incrementInstalledAt();
    function loadConfiguration($configuration);
}
