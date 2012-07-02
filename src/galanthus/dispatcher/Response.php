<?php
namespace galanthus\dispatcher;

use galanthus\dispatcher\response\DecoratorInterface;

/**
 * 
 * @author sasquatch
 *
 */
class Response implements ResponseInterface
{
    
    /**
     * Response parameters
     * 
     * @var array
     */
    protected $_params = array();
    
    /**
     * Set response parameters
     *
     * @param array $params
     * @return Response
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }
    
    /**
     * Get response parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
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
        $this->_params[$name] = $value;
        return $this;
    }
    
    /**
     * Get response parameter
     *
     * @param string $name
     * @return mixed|null
     */
    public function getParam($name)
    {
        if (array_key_exists($name, $this->_params)) {
            return $this->_params[$name];
        }
        return null;
    }
    
    /**
     * Clear response parameters
     *
     * @return Response
     */
    public function clearParams()
    {
        $this->_params = array();
        return $this;
    }
    
    /**
     * Set action decorators
     *
     * @param array $decorators Array of decorators with options
     * @return Response
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
     * @param string|DecoratorInterface $decorator Decorator name or decorator object itself
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
    public function output()
    {
        ob_end_flush();
    }
    
}