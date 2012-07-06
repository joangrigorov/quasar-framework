<?php
/**
 * Galanthus Framework © 2012
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
 * @category   Galanthus
 * @package    Galanthus View
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\view;

use galanthus\di\Container;

/**
 * Broker interface for view helpers
 *
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus View
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
interface HelperBrokerInterface
{
    
    /**
     * The default helper namespace to use
     * 
     * @var string
     */
    const DEFAULT_NAMESPACE = 'galanthus\view\helpers';
    
    /**
     * Register view helpers namespace
     * 
     * @param string $namespace
     * @return HelperBrokerInterface
     */
    public function addNamespace($namespace);
    
    /**
     * Remove view helpers namespace
     * 
     * @param string $namespace
     * @return HelperBrokerInterface
     */
    public function removeNamespace($namespace);
    
    /**
     * Set multiple namespaces at once
     * 
     * @param array $namespaces
     * @return HelperBrokerInterface
     */
    public function setNamespaces(array $namespaces);
    
    /**
     * Clear all registered namespaces
     * 
     * @return HelperBrokerInterface
     */
    public function clearNamespaces();
    
    /**
     * Get view helper 
     * 
     * If helper is not created - creates it
     * 
     * @param string $helperName
     * @return HelperInterface
     */
    public function getHelper($helperName);
    
    /**
     * Add helper instance
     * 
     * @param HelperInterface $helper
     * @param string $name Set helper access name
     * @return HelperBrokerInterface
     */
    public function addHelper(HelperInterface $helper, $name = null);
    
    /**
     * Set the dependency injection container
     * 
     * @param Container $injector
     * @return HelperBrokerInterface
     */
    public function setInjector(Container $injector);
    
    /**
     * Get the dependency injection container
     * 
     * @return Container
     */
    public function getInjector();
    
}