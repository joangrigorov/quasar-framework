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

use galanthus\di\lifecycle\LifecycleInterface,
    galanthus\di\lifecycle\Shared,
    galanthus\di\lifecycle\Factory,
    galanthus\di\lifecycle\Value;

/**
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dependency Injection
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Context implements ContextInterface
{

    /**
     * The parent context
     * 
     * @var ContextInterface
     */
    protected $_parent;

    /**
     * Class repository
     * 
     * @var ClassRepository
     */
    protected $_repository;

    /**
     * Registered preferences
     * 
     * @var multitype:LifecycleInterface
     */
    protected $_registry = array();
    
    /**
     * Container for variable contexts
     * 
     * @var mutlitype:Variable
     */
    protected $_variables = array();

    /**
     * Container for contexts
     * 
     * @var multitype:ContextInterface
     */
    protected $_contexts = array();

    /**
     * Container for types
     * 
     * @var multitype:Type
     */
    protected $_types = array();

    /**
     * Container for wrappers
     * 
     * @var array
     */
    protected $_wrappers = array();

    /**
     * Consructor
     * 
     * Sets the parent context
     * 
     * @param ContextInterface $parent
     */
    public function __construct(ContextInterface $parent)
    {
        $this->_parent = $parent;
    }
    
    /**
     * Get parent context
     * 
     * @return ContextInterface
     */
    public function getParent()
    {
        return $this->_parent;
    }
    
    /**
     * Will use condition
     *
     * @param mixed $preference
     * @return void
     */
    public function willUse($preference)
    {
        if ($preference instanceof LifecycleInterface) {
            $lifecycle = $preference;
        } elseif (is_object($preference)) {
            $lifecycle = new Value($preference);
        } else {
            $lifecycle = new Factory($preference);
        }
        array_unshift($this->_registry, $lifecycle);
    }

    /**
     * Conditions for a variable
     *
     * @param string $name
     * @return Variable
     */
    public function forVariable($name)
    {
        return $this->_variables[$name] = new Variable($this);
    }

    /**
     * Get context when creating instance
     *
     * @param string $type
     * @return ContextInterface
     */
    public function whenCreating($type)
    {
        if (! isset($this->_contexts[$type])) {
            $this->_contexts[$type] = new self($this);
        }
        return $this->_contexts[$type];
    }

    /**
     * Get context for type
     *
     * @param string $type
     * @return Type
     */
    public function forType($type)
    {
        if (! isset($this->_types[$type])) {
            $this->_types[$type] = new Type();
        }
        return $this->_types[$type];
    }

    /**
     * Wrap with
     *
     * @param string $type
     * @return void
     */
    public function wrapWith($type)
    {
        array_push($this->_wrappers, $type);
    }
    
    /**
     * Find the top context in the chain
     * 
     * @param Context $context
     * @return Context
     */
    protected function _getTopContext(Context $context)
    {
        if ($context->getParent() instanceof Container) {
            return $context;
        }
        return $this->_getTopContext($context->getParent());
    }
    
    /**
     * Merge variables from two contexts
     * 
     * @param Context $from
     * @param Context $to
     * @return void
     */
    protected function _mergeVars(Context $from, Context $to)
    {
        $to->variables = array_merge($from->variables, $to->variables);
    }
    
    /**
     * Inherit variables from a parent context
     * 
     * @param string $type
     * @param Context $context
     * @return void
     */
    protected function _inheritVars($type, Context $context)
    {
        $topContext = $this->_getTopContext($context);
        
        if (!isset($topContext->_contexts[$type])) {
            return;
        }
        
        $parentContext = $topContext->_contexts[$type];
        
        $this->_mergeVars($parentContext, $context);
    }

    /**
     * Create new instance
     *
     * @param string $type Class to instantiate
     * @param array $nesting
     * @return mixed
     */
    public function create($type, $nesting = array())
    {
        class_exists($type, true);
        
        $lifecycle = $this->pickFactory($type, 
                $this->getRepository()
                    ->candidatesFor($type));
        
        $context = $this->_determineContext($lifecycle->getClass());
        
        if ($context->hasWrapper($type, $nesting)) {
            $wrapper = $context->getWrapper($type, $nesting);
            return $this->create($wrapper, $this->_cons($wrapper, $nesting));
        }
        
        $this->_inheritVars($type, $context);
        
        $instance = $lifecycle->instantiate(
            $context->createDependencies(
                $this->getRepository()
                     ->getConstructorParameters($lifecycle->getClass()), 
                $this->_cons($lifecycle->getClass(), $nesting)
            )
        );
        
        if ($lifecycle->shouldInvokeSetters()) {
            $this->_invokeSetters($context, $nesting, $lifecycle->getClass(), $instance);
        }
        
        return $instance;
    }

    /**
     * Choose factory class
     *
     * @param string $type 
     * @param array $candidates
     * @return LifecycleInterface
     */
    public function pickFactory($type, $candidates)
    {
        if (count($candidates) == 0) {
            throw new DiException('Cannot find implementation of ' . $type);
        } elseif ($this->hasPreference($candidates)) {
            return $this->preferFrom($candidates);
        } elseif (count($candidates) == 1) {
            return new Factory($candidates[0]);
        } else {
            return $this->getParent()
                        ->pickFactory($type, $candidates);
        }
    }

    /**
     * Check for a wrapper class
     *
     * @param string $type 
     * @param array $alreadyApplied
     * @return boolean
     */
    public function hasWrapper($type, $alreadyApplied)
    {
        foreach ($this->wrappersFor($type) as $wrapper) {
            if (!in_array($wrapper, $alreadyApplied)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get wrapper class
     *
     * @param string $type 
     * @param array $alreadyApplied
     * @return mixed
     */
    public function getWrapper($type, $alreadyApplied)
    {
        foreach ($this->wrappersFor($type) as $wrapper) {
            if (!in_array($wrapper, $alreadyApplied)) {
                return $wrapper;
            }
        }
        return null;
    }

    /**
     * Invoke setter methods
     * 
     * Used for setter injection
     * 
     * @param ContextInterface $context Context to use
     * @param array $nesting
     * @param string $class
     * @param mixed $instance Instance, on which to invoke setters
     */
    protected function _invokeSetters(ContextInterface $context, $nesting, $class, $instance)
    {
        foreach ($context->settersFor($class) as $setter) {
            
            $context->_invoke(
                $instance, $setter, $context->createDependencies(
                    $this->getRepository()
                         ->getParameters($class, $setter), 
                    $this->_cons($class, $nesting)
                )
            );
        }
    }

    /**
     * Get setter methods for the given class
     *
     * @param string $class
     * @return array
     */
    public function settersFor($class)
    {
        $reflection = new \ReflectionClass($class);
        $interfaces = $reflection->getInterfaces();
        
        $interfaceSetters = array();
        
        foreach ($interfaces as $interface => $interfaceReflection) {
            if (isset($this->_types[$interface])) {
                $interfaceSetters = array_merge($interfaceSetters, 
                        $this->_types[$interface]->getSetters());
            }
        }
        
        $setters = isset($this->_types[$class]) ? $this->_types[$class]->getSetters() : array();
        return array_values(
            array_unique(
                array_merge(
                    $setters, 
                    $this->getParent()->settersFor($class), 
                    $interfaceSetters
                )
            )
        );
    }


    /**
     * Get wrapper for type
     *
     * @param $type
     * @return array
     */
    public function wrappersFor($type)
    {
        return array_values(
            array_merge(
                $this->_wrappers, $this->getParent()->wrappersFor($type)
            )
        );
    }

    /**
     * Create dependencies
     *
     * @param array $parameters 
     * @param array $nesting
     * @return array
     */
    public function createDependencies($parameters, $nesting)
    {
        $values = array();
        foreach ($parameters as $parameter) {
            /* @var $parameter ReflectionParameter */
            try {
                $values[] = $this->instantiateParameter($parameter, $nesting);
            } catch (\Exception $e) {
                if ($parameter->isOptional()) {
                    break;
                }
                throw $e;
            }
        }
        
        return $values;
    }

    /**
     * Instantiate parameter
     *
     * @param \ReflectionParameter $parameter 
     * @param array $nesting
     * @return mixed
     */
    public function instantiateParameter(\ReflectionParameter $parameter, $nesting)
    {
        $hint = $parameter->getClass();
        if (!empty($hint)) {
            if (array_key_exists($parameter->getName(), $this->_variables)) {
                if ($this->_variables[$parameter->getName()]->getPreference() instanceof LifecycleInterface) {
                    return $this->_variables[$parameter->getName()]->getPreference()->instantiate(
                            array());
                } elseif (!is_string(
                        $this->_variables[$parameter->getName()]->getPreference())) {
                    return $this->_variables[$parameter->getName()]->getPreference();
                }
            }
            return $this->create($hint->getName(), $nesting);
        } elseif (isset($this->_variables[$parameter->getName()])) {
            if ($this->_variables[$parameter->getName()]->getPreference() instanceof LifecycleInterface) {
                return $this->_variables[$parameter->getName()]->getPreference()->instantiate(
                        array());
            } elseif (!is_string(
                    $this->_variables[$parameter->getName()]->getPreference())) {
                return $this->_variables[$parameter->getName()]->getPreference();
            }
            return $this->create(
                    $this->_variables[$parameter->getName()]->getPreference(),
                    $nesting);
        }
        return $this->getParent()->instantiateParameter($parameter, $nesting);
    }


    /**
     * Determine context
     *
     * @param string $class
     * @return ContextInterface
     */
    protected function _determineContext($class)
    {
        foreach ($this->_contexts as $type => $context) {
            /* @var $context ContextInterface */
            if ($this->getRepository()->isSupertype($class, $type)) {
                return $context;
            }
        }
        return $this;
    }

    /**
     * Invoke object's method
     *
     * @param mixed $instance
     * @param string $method
     * @param array $arguments
     * @return void
     */
    protected function _invoke($instance, $method, $arguments)
    {
        call_user_func_array(array(
            $instance, $method
        ), $arguments);
    }

    /**
     * Prefer type from given candidates
     *
     * @param array $candidates
     * @return LifecycleInterface|false
     */
    public function preferFrom($candidates)
    {
        foreach ($this->_registry as $preference) {
            /* @var $preference LifecycleInterface */
            if ($preference->isOneOf($candidates)) {
                return $preference;
            }
        }
        return false;
    }

    /**
     * Prefer type from given candidates
     *
     * @param array $candidates
     * @return boolean
     */
    public function hasPreference($candidates)
    {
        foreach ($this->_registry as $preference) {
            /* @var $preference LifecycleInterface */
            if ($preference->isOneOf($candidates)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $head
     * @param array $tail
     * @return array
     */
    protected function _cons($head, $tail)
    {
        array_unshift($tail, $head);
        return $tail;
    }

    /**
     * Get class repository
     *
     * @return ClassRepository
     */
    public function getRepository()
    {
        return $this->getParent()->getRepository();
    }
}