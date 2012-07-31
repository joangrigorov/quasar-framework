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
 * @package    Quasar Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch
 */

namespace Quasar\Di;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Quasar
 * @package    Quasar Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch
 */
class ReflectionCache
{

    /**
     * Interface implementations
     * 
     * @var array
     */
    protected $implementationsOf = array();

    /**
     * Class interfaces
     * 
     * @var array
     */
    protected $interfacesOf = array();

    /**
     * Reflections cache
     * 
     * @var array
     */
    protected $reflections = array();

    /**
     * Subclasses
     * 
     * @var array
     */
    protected $subclasses = array();

    /**
     * Classes parents
     * 
     * @var array
     */
    protected $parents = array();

    /**
     * Update index
     */
    public function refresh()
    {
        $this->buildIndex(array_diff(get_declared_classes(), $this->indexed()));
        $this->subclasses = array();
    }

    /**
     * Get implementation of given interface
     * 
     * @param string $interface
     * @return array
     */
    public function implementationsOf($interface)
    {
        
        return isset($this->implementationsOf[$interface]) ? 
               $this->implementationsOf[$interface] : 
               array();
    }

    /**
     * Get interfaces of given class
     * 
     * @param string $class
     * @return array
     */
    public function interfacesOf($class)
    {
        return isset($this->interfacesOf[$class]) ? 
               $this->interfacesOf[$class] : 
               array();
    }

    /**
     * Get subclasses of given class
     * 
     * @param string $class
     * @return array
     */
    public function concreteSubgraphOf($class)
    {
        if (!class_exists($class)) {
            return array();
        }
        if (!isset($this->subclasses[$class])) {
            $this->subclasses[$class] = $this->isConcrete($class) ? array(
                $class
            ) : array();
            foreach ($this->indexed() as $candidate) {
                if (is_subclass_of($candidate, $class) && $this->isConcrete($candidate)) {
                    $this->subclasses[$class][] = $candidate;
                }
            }
        }
        return $this->subclasses[$class];
    }

    /**
     * Get parents of given class
     * 
     * @param string $class
     * @return array
     */
	public function parentsOf($class)
	{
		if (! isset($this->parents[$class])) {
			$this->parents[$class] = class_parents($class);
		}
		return $this->parents[$class];
	}

	/**
	 * Get class reflection
	 * 
	 * @param string $class
	 * @return \ReflectionClass
	 */
	public function getReflection($class)
	{
		if (! isset($this->reflections[$class])) {
			$this->reflections[$class] = new \ReflectionClass($class);
		}
		return $this->reflections[$class];
	}

	/**
	 * Is class concrete (it's concrete when it's not abstract)
	 * 
	 * @param string $class
	 * @return boolean
	 */
	protected function isConcrete($class)
	{
		return !$this->getReflection($class)
		             ->isAbstract();
	}

	/**
	 * Get indexed interfaces
	 * 
	 * @return array
	 */
	protected function indexed()
	{
		return array_keys($this->interfacesOf);
	}

	/**
	 * Create index
	 * 
	 * @param array $classes
	 * @return void
	 */
	protected function buildIndex(array $classes)
	{
		foreach ($classes as $class) {
			$interfaces = array_values(class_implements($class));
			$this->interfacesOf[$class] = $interfaces;
			foreach ($interfaces as $interface) {
				$this->crossReference($interface, $class);
			}
		}
	}

	/**
	 * Register interface implementation
	 * 
	 * @param string $interface
	 * @param string $class
	 * @return void
	 */
	protected function crossReference($interface, $class)
	{
		if (! isset($this->implementationsOf[$interface])) {
			$this->implementationsOf[$interface] = array();
		}
		$this->implementationsOf[$interface][] = $class;
		$this->implementationsOf[$interface] = array_values(
				array_unique($this->implementationsOf[$interface]));
	}
}