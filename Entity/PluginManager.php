<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PluginsBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\PluginsBundle\Model\PluginInterface;
use Sylius\Bundle\PluginsBundle\Model\PluginManager as BasePluginManager;

/**
 * ORM plugin manager.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PluginManager extends BasePluginManager
{
    /**
     * Entity manager.
     * 
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * Plugin entity repository.
     * 
     * @var EntityRepository
     */
    protected $repository;
    
    /**
     * Constructor.
     * 
     * @param EntityManager $entityManager
     * @param string		$class
     */
    public function __construct(EntityManager $entityManager, $class)
    {
        parent::__construct($class);
        
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->getClass());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createPlugin()
    {
        $class = $this->getClass();
        return new $class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function persistPlugin(PluginInterface $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function removePlugin(PluginInterface $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findPlugin($id)
    {
        return $this->repository->find($id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findPluginBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findPlugins()
    {
        return $this->repository->findAll();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findPluginsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }
}
