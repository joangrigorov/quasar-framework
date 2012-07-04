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

use galanthus\di\Context,
    galanthus\di\lifecycle\LifecycleInterface;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Container implements ContextInterface
{
    
    /**
     * Default top context
     * 
     * @var ContextInterface
     */
    protected $top;
    
    /**
     * Named parameters to use for the next object instantiation
     * 
     * @var array
     */
    protected $namedParameters = array();
    
    /**
     * Unamed parameters to use for the next object instantiation
     *
     * @var array
     */
    protected $unnamedParameters = array();
    
    /**
     * Class repository
     * 
     * @var ClassRepository
     */
    protected $repository;
    
    /**
     * Array with instances to use as shared objects
     * 
     * @var array
     */
    protected $instances = array();
    
    /**
     * Array with aliases for the Service Locator
     * 
     * @var array
     */
    protected $aliases = array();

    /**
     * Constructor
     * 
     * Creates the default top context
     * 
     * @param array $config Container configuration
     */
    public function __construct(array $config = null)
    {
        $this->top = new Context($this);
        if (null !== $config) {
            $this->addConfig($config, $this);
        }
    }
    
    /**
     * Add container configuration
     * 
     * @param array $config
     * @param ContextInterface $context
     */
    public function addConfig(array $config, ContextInterface $context = null)
    {    
        
        if (null === $context) {
            $context = $this;
        }
        
        foreach ($config as $class => $settings) {
            // Get configuration for injection methods
            if (!empty($settings['call'])) {
                $type = $context->forType($class);
                foreach ($settings['call'] as $method) {
                    $type->call($method);
                }
            }
    
            if (!empty($settings['alias']) && $context instanceof Container) {
                $context->registerAlias($class, $settings['alias']);
            }
    
            if (!empty($settings['shared']) && $settings['shared']) {
                class_exists($class, true);
                $context->willUse(new \galanthus\di\lifecycle\Shared($class));
            }
    
            if (!empty($settings['params'])) {
                $whenCreating = $context->whenCreating($class);
                foreach ($settings['params'] as $param => $value) {
                    if (is_string($value)) {
                        $whenCreating->forVariable($param)
                                     ->useString($value);
                    } elseif($value instanceof \galanthus\di\lifecycle\LifecycleInterface) {
                        $whenCreating->willUse($value);
                    } else {
                        $whenCreating->forVariable($param)
                                     ->willUse($value);
                    }
                }
            }
    
            if (isset($settings['instances'])) {
                $this->setConfig($settings['instances'], $context->whenCreating($class));
            }
    
        }
    }
    
    /**
     * Sets the top context container
     * 
     * @param ContextInterface $context
     * @return Container
     */
    public function setTop(ContextInterface $context)
    {
        $this->top = $context;
        return $this;
    }
    
    /**
     * Gets the top context container
     * 
     * @return ContextInterface
     */
    public function getTop()
    {
        return $this->top;
    }
    
    /**
     * Sets named parameters
     * 
     * @param array $parameters
     * @return Container
     */
    public function setNamedParameters(array $parameters)
    {
        $this->namedParameters = $parameters;
        return $this;
    }
    
    /**
     * Gets named paramters
     * 
     * @return array
     */
    public function getNamedParameters()
    {
        return $this->namedParameters;
    }
    
    /**
     * Sets unnamed parameters
     * 
     * @param array $parameters
     * @return Container
     */
    public function setUnnamedParameters(array $parameters)
    {
        $this->unnamedParameters = $parameters;
        return $this;
    }
    
    /**
     * Gets unnamed paramters
     * 
     * @return array
     */
    public function getUnnamedParameters()
    {
        return $this->unnamedParameters;
    }
    
    /**
     * Sets class repository instance
     * 
     * @param ClassRepository $repository
     * @return Container
     */
    public function setRepository(ClassRepository $repository)
    {
        $this->repository = $repository;
        return $this;
    }
    
    /**
     * Gets class reposotory instance
     * 
     * @return ClassRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
    
    /**
     * Value (could be anything) to use with object instantiations
     * 
     * @param mixed $preference
     * @return Container
     */
    public function willUse($preference)
    {
        $this->getTop()->willUse($preference);
        return $this;
    }

    /**
     * Conditions for a variable
     * 
     * @param string $name Variable name
     * @return Variable
     */
    public function forVariable($name)
    {
        return $this->getTop()->forVariable($name);
    }
    
    /**
     * Get context when creating instance
     *
     * @param string $type Class/interface name
     * @return Context
     */
    public function whenCreating($type)
    {
        return $this->getTop()->whenCreating($type);
    }

    /**
     * Get context for type
     *
     * @param string $type Class/interface name
     * @return Type
     */
    public function forType($type)
    {
        return $this->getTop()->forType($type);
    }

    /**
     * Create parameter placeholders
     * 
     * @return IncomingParameters
     */
    public function fill()
    {
        $names = func_get_args();
        return new IncomingParameters($names, $this);
    }

    /**
     * Fill parameter placeholders
     * 
     * @return Container
     */
    public function with()
    {
        $values = func_get_args();
        $this->setUnnamedParameters(array_merge(
            $this->unnamedParameters, $values
        ));
        return $this;
    }

    /**
     * Create new instance
     * 
     * @return object
     */
    public function create()
    {
        $values = func_get_args();
        $type = array_shift($values);
        $this->setUnnamedParameters(array_merge(
            $this->unnamedParameters, $values
        ));
        $this->setRepository(new ClassRepository());
        
        if (array_key_exists($type, $this->aliases)) {
            $type = $this->aliases[$type];
        }
        
        $object = $this->getTop()->create($type);
        $this->setNamedParameters(array());
        return $object;
    }

    /**
     * Get instance as shared
     * 
     * @return object
     */
    public function get()
    {
        $values = func_get_args();
        $type = $values[0];
        
        if (array_key_exists($type, $this->aliases)) {
            $type = $this->aliases[$type];
        }
        
        if (!array_key_exists($type, $this->instances) || count($values) > 1) {
            $this->instances[$type] = call_user_func_array(array($this, 'create'), $values);
        }
        
        return $this->instances[$type];
    }

    /**
     * Register service
     * 
     * @param string $className
     * @param string $alias
     * @throws DiException
     * @return Container
     */
    public function registerAlias($className, $alias)
    {
        if (class_exists($alias)) {
            throw new DiException("Class with name '$alias' you are trying to set as alias exists");
        }
        
        $this->aliases[$alias] = $className;
        
        return $this;
    }

    /**
     * @throws DiException
     */
    public function pickFactory($type, $candidates)
    {
        throw new DiException('Cannot determine implementation of ' . $type);
    }

    /**
     * Get setter methods for the given class
     *
     * @param string $class
     * @return array
     */
    public function settersFor($class)
    {
        return array();
    }

    /**
     * @param string $type
     * @return array
     */
    public function wrappersFor($type)
    {
        return array();
    }

    /**
     * Set parameters for usage in the global context
     * 
     * @param array $parameters
     * @return Container
     */
    public function useParameters(array $parameters)
    {
        $this->setNamedParameters(array_merge(
            $this->namedParameters, $parameters
        ));
        return $this;
    }

    /**
     * @param \ReflectionParameter $parameter
     * @param boolean $nesting
     * @throws DiException
     * @return mixed
     */
    public function instantiateParameter(\ReflectionParameter $parameter, $nesting)
    {
        if (isset($this->namedParameters[$parameter->getName()])) {
            return $this->namedParameters[$parameter->getName()];
        }
        if (!empty($this->unnamedParameters)) {
            return array_shift($this->unnamedParameters);
        }
        throw new DiException('Missing dependency with name ' . $parameter->getName());
    }
}
