<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Controller\Backend;

use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\PluginsBundle\EventDispatcher\Event\FilterPluginEvent;
use Sylius\Bundle\PluginsBundle\EventDispatcher\SyliusPluginsEvents;

/**
 * Plugin backend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PluginController extends ContainerAware
{
    /**
     * Shows a plugin.
     */
    public function showAction($id)
    {
        $plugin = $this->container->get('sylius_plugins.manager.plugin')->findPlugin($id);
        
        if (!$plugin) {
            throw new NotFoundHttpException('Requested plugin does not exist.');
        }
        
        return $this->container->get('templating')->renderResponse('SyliusPluginsBundle:Backend/Plugin:show.html.' . $this->getEngine(), array(
        	'plugin' => $plugin
        ));
    }
    
    /**
     * List plugins.
     */
    public function listAction()
    {
        $plugins = $this->container->get('sylius_plugins.manager.plugin')->findPlugins(); 
        $packs = $this->container->get('sylius_plugins.packager')->findPacks($plugins);
        
        return $this->container->get('templating')->renderResponse('SyliusPluginsBundle:Backend/Plugin:list.html.' . $this->getEngine(), array(
        	'plugins'    => $plugins,
            'packs'     => $packs
        ));
    }
    
    /**
     * Installs a new plugin.
     */
    public function installAction($path)
    {
        $path = base64_decode($path); 
        $pack = $this->container->get('sylius_plugins.packager')->createPack($path);
        
        $plugin = $pack->buildPlugin($this->container->get('sylius_plugins.manager.plugin')->createPlugin());
        
        if (0 === count($this->container->get('validator')->validate($plugin))) {
            $this->container->get('event_dispatcher')->dispatch(SyliusPluginsEvents::PLUGIN_INSTALL, new FilterPluginEvent($plugin));
            $this->container->get('sylius_plugins.manipulator.plugin')->install($plugin);
            $this->container->get('sylius_plugins.manipulator.plugin')->refresh();
            
            return new RedirectResponse($this->container->get('router')->generate('sylius_plugins_backend_plugin_list'));
        }
        
        throw new RuntimeException('Plugin configuration was invalid.');
    }

	/**
     * Deletes plugins.
     */
    public function uninstallAction($id)
    {
        $plugin = $this->container->get('sylius_plugins.manager.plugin')->findPlugin($id);
        
        if (!$plugin) {
            throw new NotFoundHttpException('Requested plugin does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusPluginsEvents::PLUGIN_UNINSTALL, new FilterPluginEvent($plugin));
        $this->container->get('sylius_plugins.manipulator.plugin')->uninstall($plugin);
        $this->container->get('sylius_plugins.manipulator.plugin')->refresh();
        
        return new RedirectResponse($this->container->get('router')->generate('sylius_plugins_backend_plugin_list'));
    }
    
	/**
     * Enables plugin.
     */
    public function enableAction($id)
    {
        $plugin = $this->container->get('sylius_plugins.manager.plugin')->findPlugin($id);
        
        if (!$plugin) {
            throw new NotFoundHttpException('Requested plugin does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusPluginsEvents::PLUGIN_ENABLE, new FilterPluginEvent($plugin));
        $this->container->get('sylius_plugins.manipulator.plugin')->enable($plugin);
        $this->container->get('sylius_plugins.manipulator.plugin')->refresh();
        
        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }
    
	/**
     * Disables plugin.
     */
    public function disableAction($id)
    {
        $plugin = $this->container->get('sylius_plugins.manager.plugin')->findPlugin($id);
        
        if (!$plugin) {
            throw new NotFoundHttpException('Requested plugin does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusPluginsEvents::PLUGIN_DISABLE, new FilterPluginEvent($plugin));
        $this->container->get('sylius_plugins.manipulator.plugin')->disable($plugin);
        $this->container->get('sylius_plugins.manipulator.plugin')->refresh();
        
        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }
    
    /**
     * Returns templating engine name.
     * 
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('sylius_plugins.engine');
    }
}
