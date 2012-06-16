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
 * @package    Galanthus Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\di;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class ClassRepository
{
    
    /**
     * Using reflection could be very expensive. Cache is necessary
     *
     * @var ReflectionCache
     */
    protected static $_reflection = null;

	/**
     * Constructor
     * 
     * Sets reflection cache instance
     */
    function __construct()
    {
        if (null === self::$_reflection) {
            self::$_reflection = new ReflectionCache();
        }
        self::$_reflection->refresh();
    }

	/**
     * Get candidates for the given type
     * 
     * @param string $interface
     * @return array
     */
    public function candidatesFor($interface)
    {
        self::$_reflection->refresh();
        
        return array_merge(self::$_reflection->concreteSubgraphOf($interface), 
                self::$_reflection->implementationsOf($interface));
    }

	/**
     * Check is class supertype of the given type
     * 
     * @param string $class
 	 * @param string $type
     * @return boolean
     */
    public function isSupertype($class, $type)
    {
        $supertypes = array_merge(
            array($class), 
            self::$_reflection->interfacesOf($class), 
            self::$_reflection->parentsOf($class)
        );
        return in_array($type, $supertypes);
    }

    /**
     * Get parameters in the constructor
     * 
     * @param string $class
     * @return array
     */
    public function getConstructorParameters($class)
    {
        $reflection = self::$_reflection->getReflection($class);
        $constructor = $reflection->getConstructor();
        if (empty($constructor)) {
            return array();
        }
        /* @var $constructor ReflectionMethod */
        return $constructor->getParameters();
    }

	/**
     * Get method parameters
     * 
     * @param string $class
     * @param string $method
     * @return array
     */
    public function getParameters($class, $method)
    {
        $reflection = self::$_reflection->getReflection($class);
        if (!$reflection->hasMethod($method)) {
            throw new DiException("Setter method '$method' not found in '$class'");
        }
        
        return $reflection->getMethod($method)
                          ->getParameters();
    }
}