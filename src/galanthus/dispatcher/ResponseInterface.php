<?php

namespace galanthus\dispatcher;

/**
 * @todo Parses the requested url and finds the requested controller and etc.
 */
interface ResponseInterface
{
    
    /**
     * Set response parameters
     * 
     * @param array $params
     * @return ResponseInterface
     */
    public function setParams(array $params);
    
    /**
     * Get response parameters
     * 
     * @return array
     */
    public function getParams();
    
    /**
     * Set response parameter
     * 
     * @param string $name
     * @param mixed $value
     * @return ResponseInterface
     */
    public function setParam($name, $value);
    
    /**
     * Get response parameter
     * 
     * @param string $name
     * @return mixed
     */
    public function getParam($name);
    
    /**
     * Clear response parameters
     * 
     * @return ResponseInterface
     */
    public function clearParams();
        
    /**
     * Set action decorators
     *
     * @param array $decorators Array of decorators with options
     * @return ResponseInterface
     */
    public function setDecorators(Array $decorators);
    
    /**
     * Get registered decorators
     *
     * @return array
     */
    public function getDecorators();
    
    /**
     * Add decorator with options
     *
     * @param string|\galanthus\dispatcher\response\DecoratorInterface $decorator Decorator name
     *                                                            or decorator object itself
     * @param mixed $options Options to set to the decorator.
     *                       Can be an array object with toArray method.
     * @return ResponseInterface
     */
    public function addDecorator($decorator, $options = null);
    
    /**
     * Add many decorators at once
     *
     * @param  array $decorators
     * @return ResponseInterface
     */
    public function addDecorators(Array $decorators);
    
    /**
     * Remove single decorator
     *
     * @param string $decorator
     * @return ResponseInterface
     */
    public function removeDecorator($decorator);
    
    /**
     * Remove all registered decorators
     *
     * @return ResponseInterface
     */
    public function clearDecorators();
    
    /**
     * Get decorated output
     * 
     * @return string
     */
    public function output();
    
}