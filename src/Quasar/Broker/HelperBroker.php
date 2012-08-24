<?php
/**
 * Quasar Framework © 2012
 * Copyright © 2012 Sasquatch <Joan-Alexander Grigorov>
 *                              http://bgscripts.com
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License v3
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   Quasar
 * @package    Quasar Broker
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Broker;

use Quasar\Di\Container;

/**
 * Standard broker for helpers
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Broker
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class HelperBroker implements HelperBrokerInterface
{
    
    /**
     * Namespaces to use when calling helpers
     * 
     * @var array
     */
    protected $namespaces = array();
    
    /**
     * Helper instances
     * 
     * @var array
     */
    protected $helpers = array();
    
    /**
     * Dependency Injection container
     * 
     * @var Container
     */
    protected $injector;
    
    /**
     * Constructor
     * 
     * Sets dependency injection container and namespaces
     * 
     * @param Container $injector
     * @param array $namespaces
     */
    public function __construct(Container $injector, array $namespaces = null)
    {
        $this->injector = $injector;
        
        if (null !== $namespaces) {
            $this->setNamespaces($namespaces);
        }
    }
    
    /**
     * Get all registered namespaces
     * 
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }
    
    /**
     * Register helpers namespace
     * 
     * @param string $namespace
     * @return HelperBroker
     */
    public function addNamespace($namespace)
    {
        if (!in_array($namespace, $this->namespaces)) {
            $this->namespaces[] = $namespace;
        }
        return $this;
    }
    
    /**
     * Remove helpers namespace
     * 
     * @param string $namespace
     * @return HelperBroker
     */
    public function removeNamespace($namespace)
    {
        $key = array_search($namespace, $this->namespaces);
        
        if (false !== $key) {
            unset($this->namespaces[$key]);
        }
        return $this;
    }
    
    /**
     * Set multiple namespaces at once
     * 
     * @param array $namespaces
     * @return HelperBroker
     */
    public function setNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
        
        return $this;
    }
    
    /**
     * Clear all registered namespaces
     * 
     * @return HelperBroker
     */
    public function clearNamespaces()
    {
        $this->namespaces = array();
        return $this;
    }
    
    /**
     * Get the helper full class name
     * 
     * Using the registered namespaces
     * 
     * @param string $helperName
     * @throws HelperBrokerException
     * @return string
     */
    protected function locateHelper($helperName)
    {
        $namespaces = array_reverse($this->namespaces);
        
        foreach ($namespaces as $namespace) {
            $class = $namespace . '\\' . ucfirst($helperName);
            if (class_exists($class, true)) {
                return $class;
            }
        }
        
        throw new HelperBrokerException("Helper by the name of '$helperName' not found");
    }
    
    /**
     * Instantiate helper
     * 
     * @param string $helperClass
     * @throws HelperBrokerException When helper class doesn't implement {@see HelperInterface}
     * @return HelperInterface
     */
    protected function instantiateHelper($helperClass)
    {
        $instance = $this->getInjector()->get($helperClass);
        
        if (!$instance instanceof HelperInterface) {
            throw new HelperBrokerException("'$helperClass' doesn't implement Quasar\Broker\HelperInterface");
        }
        
        return $instance;
    }
    
    /**
     * Get helper's class short name
     * 
     * @param HelperInterface $helper
     * @return string
     */
    protected function getShortName(HelperInterface $helper)
    {
        $reflection = new \ReflectionClass($helper);
        return $reflection->getShortName();
    }
    
    /**
     * Get all registered helpers
     * 
     * @return array
     */
    public function getHelpers()
    {
        return $this->helpers;
    }
    
    /**
     * Get helper 
     * 
     * If helper is not created - creates it
     * 
     * @param string $helperName
     * @return HelperInterface
     */
    public function getHelper($helperName)
    {
        $helperNameFixed = strtolower($helperName);
        
        if (array_key_exists($helperNameFixed, $this->helpers)) {
            return $this->helpers[$helperNameFixed];
        }
        
        $helperClass = $this->locateHelper($helperName);
        
        $helper = $this->instantiateHelper($helperClass);
        
        $this->helpers[$helperNameFixed] = $helper;
        
        return $helper;
    }
    
    /**
     * Add helper instance
     * 
     * @param HelperInterface $helper
     * @param boolean $overwrite If true overwrites previous helper on conflict
     * @return HelperBroker
     */
    public function addHelper(HelperInterface $helper, $overwrite = true)
    {
        $helperName = $this->getShortName($helper);
        $helperFixedName = strtolower($helperName);
        
        if (array_key_exists($helperFixedName, $this->helpers) && !$overwrite) {
            return $this;
        }
        
        $this->helpers[$helperFixedName] = $helper;        
        return $this;
    }
    
    /**
     * Remove all registered helpers
     * 
     * @return HelperBroker
     */
    public function clearHelpers()
    {
        $this->helpers = array();
        return $this;
    }
    
    /**
     * Set the dependency injection container
     * 
     * @param Container $injector
     * @return HelperBroker
     */
    public function setInjector(Container $injector)
    {
        $this->injector = $injector;
        return $this;
    }
    
    /**
     * Get the dependency injection container
     * 
     * @return Container
     */
    public function getInjector()
    {
        return $this->injector;
    }
    
}