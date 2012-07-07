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
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */

namespace galanthus\dispatcher;

use galanthus\di\Container,
    galanthus\dispatcher\ResponseException,
    galanthus\dispatcher\response\DecoratorInterface;

/**
 * Metallica - Battery (music)
 * 
 * @author     Joan-Alexander Grigorov http://bgscripts.com
 * @category   Galanthus
 * @package    Galanthus Dispatcher
 * @copyright  Copyright (c) 2012 Sasquatch, Elegance Team
 */
class Response implements ResponseInterface
{
    
    /**
     * Dependency injection container
     *
     * @var Container
     */
    protected $injector;
    
    /**
     * Response parameters
     * 
     * @var array
     */
    protected $params = array();
    
    /**
     * Response decorators
     * 
     * @var array
     */
    protected $decorators = array();
    
    /**
     * Constructor
     * 
     * Sets dependencies
     * 
     * @param Container $injector
     */
    public function __construct(Container $injector, 
                                array $decorators = null,
                                array $params = null)
    {
        $this->injector = $injector;
        
        if (null !== $decorators) {
            $this->setDecorators($decorators);
        }
        
        if (null != $params)  {
            $this->setParams($params);
        }
        
    }
    
    /**
     * Set the dependency injection container instance
     * 
     * @param Container $injector
     * @return Response
     */
    public function setInjector(Container $injector)
    {
        $this->injector = $injector;
        return $this;
    }
    
    /**
     * Get the dependency injection container instance
     * 
     * @return Container
     */
    public function getInjector()
    {
        return $this->injector;
    }
    
    /**
     * Set response parameters
     *
     * @param array $params
     * @return Response
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
    
    /**
     * Get response parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Set response parameter
     *
     * @param string $name
     * @param mixed $value
     * @return Response
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }
    
    /**
     * Get response parameter
     *
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed|null
     */
    public function getParam($name, $defaultValue = null)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return $defaultValue;
    }
    
    /**
     * Clear response parameters
     *
     * @return Response
     */
    public function clearParams()
    {
        $this->params = array();
        return $this;
    }
    
    /**
     * Overriding: allowing property access
     * 
     * Accessing response parameters
     * 
     * @param string $name
     * @return mixed|NULL
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return null;
    }
    
    /**
     * Overriding: allowing property access
     *
     * Setting response parameters
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    /**
     * Overriding: allowing quick access to decorators
     * 
     * @param string $name
     * @param array $arguments
     * @return DecoratorInterface
     */
    public function __call($name, $arguments)
    {
        $pattern = '^get(?P<decorator>[a-zA-Z]+?)$';
        if (preg_match($pattern, $name, $matches)) {
            $decoratorName = $matches['decorator'];
            if (array_key_exists($decoratorName, $this->decorators)) {
                return $this->decorators[$decoratorName];
            }
        }
        throw new ResponseException("Method '$name' is not defined");
    }
    
    /**
     * Set action decorators
     *
     * @param array $decorators Array of decorators with options
     * @return Response
     */
    public function setDecorators(Array $decorators)
    {
        $this->clearDecorators()
             ->addDecorators($decorators);
        
        return $this;
    }
    
    /**
     * Get registered decorators
     *
     * @return multitype:DecoratorInterface
     */
    public function getDecorators()
    {
        return $this->decorators;
    }
    
    /**
     * Get decorator's class short name
     * 
     * @param DecoratorInterface $decorator
     * @return string
     */
    protected function getShortName(DecoratorInterface $decorator)
    {
        $reflection = new \ReflectionClass($decorator);
        return $reflection->getShortName();
    }
    
    /**
     * Add decorator with options
     *
     * @param string|DecoratorInterface $decorator Decorator name or decorator object itself
     * @param mixed $options Options to set to the decorator.
     *                       Can be an array object with toArray method.
     * @return Response
     * @throws ResponseException When the decorator class doesn't implement DecoratorInterface
     * @throws ResponseException When the decorator is not string or DecoratorInterface instance
     */
    public function addDecorator($decorator, $options = null)
    {
        if (is_string($decorator)) {
            $name = $decorator;
            
            if (class_exists($name, true)) {
                $decoratorClass = $name;
            } else {
                $decoratorClass = self::DECORATORS_NAMESPACE . ucfirst($name);
                if (!class_exists($decoratorClass, true)) {
                    throw new ResponseException('Decorator class not found');
                }
            }
            
            // use the dependency injection container to create the decorator
            $decorator = $this->getInjector()->create($decoratorClass);
            
            if (!$decorator instanceof DecoratorInterface) {
                throw new ResponseException("'$decoratorClass' must implement galanthus\dispatcher\response\DecoratorInterface");
            }
            
            $decorator->setResponse($this);
                        
            if (null !== $options) {
                $decorator->setOptions($options);
            }
            
            $this->decorators[strtolower($this->getShortName($decorator))] = $decorator;
        } else if (is_object($decorator)) {
            if ($decorator instanceof DecoratorInterface) {
                if (null !== $options) {
                    $decorator->setOptions($options);
                }
                $decorator->setResponse($this);
                $this->decorators[strtolower($this->getShortName($decorator))] = $decorator;
            } else {
                throw new ResponseException("'$decorator' must implement galanthus\dispatcher\response\DecoratorInterface");
            }
        } else {
            throw new ResponseException("'$decorator' must be decorator name or galanthus\dispatcher\response\DecoratorInterface implementation");
        }
        
        return $this;
    }
    
    /**
     * Add many decorators at once
     *
     * @param  array $decorators
     * @return Response
     * @throws ResponseException When invalid decorator is passed
     */
    public function addDecorators(Array $decorators)
    {
        foreach ($decorators as $decoratorName => $decoratorInfo) {
            if (is_string($decoratorInfo) ||
                    $decoratorInfo instanceof DecoratorInterface) {
                if (!is_numeric($decoratorName)) {
                    $this->addDecorator($decoratorName, $decoratorInfo);
                } else {
                    $this->addDecorator($decoratorInfo);
                }
            } elseif (is_array($decoratorInfo)) {
                $argc    = count($decoratorInfo);
                $options = array();
                if (isset($decoratorInfo['name'])) {
                    $decorator = $decoratorInfo['name'];
                    $this->addDecorator($decorator, $decoratorInfo);
                } else {
                    if (is_string($decoratorName)) {
                        $this->addDecorator($decoratorName, $decoratorInfo);
                    }
                }
            } else {
                throw new ResponseException('Invalid decorator passed to addDecorators()');
            }
        }
    }
    
    /**
     * Remove single decorator
     *
     * @param string $decorator
     * @return Response
     */
    public function removeDecorator($decorator)
    {
        if (array_key_exists($decorator, $this->decorators)) {
            unset($this->decorators[$decorator]);
        }
        
        return $this;
    }
    
    /**
     * Remove all registered decorators
     *
     * @return Response
     */
    public function clearDecorators()
    {
        $this->decorators = array();
        return $this;
    }
    
    /**
     * Get decorated output
     *
     * @return string
     */
    public function output()
    {
        $content = '';
        
        foreach ($this->getDecorators() as $decorator) {
            /* @var $decorator DecoratorInterface */
            $content = $decorator->decorate($content);
        }
        return $content;
    }
    
}